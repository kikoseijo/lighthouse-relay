var Client = function Client(location) {
    this.authClient = null;
    this.location = location;
    this.data = {};
    this._setupAuth();
    this._setupEventHandlers();
    console.log(this.location);
};

Client.prototype._updateStatus = function _updateStatus(status) {
    $('#responsePanel').removeClass('panel-danger panel-success').addClass('panel-'+status);
};

Client.prototype._clearResponseLists = function _clearResponseLists() {
    $('.responseList').html();
};

Client.prototype._login = function _login() {
    var self = this;

    if ($('#loginForm').is(':visible')) {

        var go = true;
        $("#loginForm input.required").each(function() {
            if(!(this.value)) {
                $(this).closest('div.form-group').addClass('has-feedback has-error');
                go = false;
            }
        });
        if (!go) {
            alert('Please fill in all values');
        } else {
            $("#loginForm div.form-group").removeClass('has-feedback has-error');
            var path = $('#loginForm select[name="endpoint"]').val();
            $.ajax({
                url: (self.location ? "/" + self.location : "") + "/" + path, // + '?XDEBUG_SESSION_START=session_start',
                method: "POST",
                data: $('#loginForm').serialize(),
                statusCode: {
                    200: function(response) {
                        if (response.token === undefined && response.accessToken === undefined) {
                            $('#response').val('OK 200 ['+Date()+']:\nBut no token');
                            self._updateStatus('danger');
                        } else {
                            // check which tokens were returned
                            if (response.accessToken) {
                                self.authClient.login(response.accessToken, response.accessTokenExpiration);
                            } else {
                                self.authClient.login(response.token);
                            }
                            $('#loginForm').hide();
                            self._updateStatus('success');
                            self._clearResponseLists();
                        }
                    },
                    401: function(response) {
                        $('#response').val('Error 401 ['+Date()+']:\nLogin failed');
                        self._updateStatus('danger');
                    },
                    500: function() {
                        $('#response').val('Error 500 ['+Date()+']:\nInternal Server Error');
                        self._updateStatus('danger');
                    }
                }
            });
        }
    } else {
        $('#loginForm').show();
    }

};

Client.prototype._logout = function _logout() {
    this.authClient.logout();
    this._clearResponseLists();
};

Client.prototype._request = function _request() {
    var self = this;
    var resource = $.ajax({
        url: (self.location ? "/" + self.location : "") + "/oauth/scopes",
        dataType: 'json',
        statusCode: {
            400: function(response) {
                $('#response').val('Error 400 ['+Date()+']:\n'+response.responseJSON.message);
                self._updateStatus('danger');
            },
            401: function(response) {
                $('#response').val('Error 401 ['+Date()+']:\n'+response.responseJSON.message);
                self._updateStatus('danger');
            }
        }
    })
    .done(function(response) {
        $('#response').val('Success ['+Date()+']:\n' + JSON.stringify(response));
        self._updateStatus('success');
    });
};


Client.prototype._setupAuth = function _setupAuth() {
    var self = this;

    this.authClient = new jqOAuth({
        events: {
            login: function() {
                $('#response').val('Success ['+Date()+']:\nYou are now authenticated.');
                self._updateStatus('success');
            },
            logout: function() {
                $('#response').val('Success ['+Date()+']:\nYou are now logged out.');
                self._updateStatus('success');
            },
            tokenExpiration: function() {
               return $.post("/refresh-token").success(function(response){
                   if (response.accessToken) {
                       self.authClient.setAccessToken(response.accessToken, response.accessTokenExpiration);
                   } else {
                       self.authClient.setAccessToken(response.token, response.tokenExpiration);
                   }
               });
            }
        }
    });
};

Client.prototype._setupEventHandlers = function _setupEventHandlers() {
    $("#login").click(this._login.bind(this));
    $('#loginForm').submit(function(){$("#login").click();return false;});
    $("#request").click(this._request.bind(this));
    $("#logout").click(this._logout.bind(this));
    var self = this;

    // on tab change
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // newly activated tab
        window.location.hash = e.target.hash;
    });
};

$(document).ready(function() {

    var hash = window.location.hash;
    hash && $('a[data-toggle="tab"][href="' + hash + '"]').tab('show');

    // check if url contains location
    var location = window.location.pathname.match(/\/([\d]+)\//);
    if (location && location.length == 2) {
        location = location[1];
    }

    var client = new Client(location);
});
