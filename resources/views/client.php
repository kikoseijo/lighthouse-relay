<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ManCloud API | Client</title>
    <script type="text/javascript" src="/vendor/jquery/dist/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/vendor/store-js/store.min.js"></script>
    <script type="text/javascript" src="/vendor/jquery-oauth/dist/jquery.oauth.min.js"></script>
    <script type="text/javascript" src="/js/client.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <!--
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    -->
    <script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    -->
    <style type="text/css">
        form {
            display: none
        }
        #response {
            min-height: 5em;
        }
        .responseList {
            display: none
        }
        #mclog {
            list-style: none;
            padding: 10px;
            margin-bottom: 0px;
        }
        #mclog li .mclogremove {
            cursor: pointer;
        }
        .mw150 {
            min-width: 150px;
        }
        thead tr td, tfoot tr td, th {
            background-color: #eee;
        }
        #graphql em, .nav-tabs li em {
            font-family: Georgia;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>API
        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#responsePanel">
            <i class="glyphicon glyphicon-eye-open"></i>
        </button>
        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal">
            <span id="mcbadge" class="badge btn-primary"></span>
        </button>
    </h1>
    <div id="responsePanel" class="panel panel-default collapse in">
        <div class="panel-heading">
            <h3 class="panel-title">Raw response</h3>
        </div>
        <div class="panel-body">
            <textarea id="response" class="form-control"></textarea>
        </div>
    </div>
</div>

<div class="container">

    <!-- Tab based layout //-->

    <div id="content" class="panel panel-default">
        <div class="panel-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-lock"></span> &nbsp; Auth
                    </a>
                </li>
                <li role="presentation">
                    <a href="#graphql" aria-controls="graphql" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-cog"></span>  &nbsp; Graph<em>i</em>QL
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="auth" class="tab-pane active" role="tabpanel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Authentication & basic OAuth test</h3>
                    </div>
                    <div class="panel-body">
                        <div class="btn-group" role="group">
                            <button id="login" class="btn btn-default"><span class="glyphicon glyphicon-log-in"></span> Login to API</button>
                            <button id="request" class="btn btn-default"><span class="glyphicon glyphicon-lock"></span> Request scopes</button>
                            <button id="logout" class="btn btn-default"><span class="glyphicon glyphicon-log-out"></span> Logout</button>
                        </div>
                        <form id="loginForm" class="form-inline">
                            <hr/>
                            <div class="form-group">
                                <label>username: </label>
                                <input type="text" class="form-control required" name="username"/>
                            </div>
                            <div class="form-group">
                                <label>password: </label>
                                <input type="password" class="form-control required" name="password"/>
                            </div>
                            <div class="form-group">
                                <label>endpoint: </label>
                                <select name="endpoint" class="form-control">
                                    <option value="login">/login</option>
                                    <option value="token">/token</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-chevron-right"></span></button>
                        </form>
                    </div>
                </div>
                <div id="graphql" class="tab-pane" role="tabpanel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Graph<em>i</em>QL Interface</h3>
                    </div>
                    <div class="panel-body">
                        <iframe src="/graphiql" width="100%" height="100%" frameborder="0" style="min-height:500px; border:solid 1px #ddd"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">API updates</h4>
            </div>
            <div class="modal-body">
                <ul id="mclog"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="clearLog">Clear updates</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>
