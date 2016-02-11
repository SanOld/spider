spi.service('network', function($http, configs, localStorageService) {
    var $network = this;
    $network.servisePath = configs.getServisePath();
    $network.token = localStorageService.get('token');
    $network.authProgress = false;
    $network.loginKey = localStorageService.get('loginKey');
    $network.user = localStorageService.get('user');

    $network.onLogin = function(){};
    $network.onLogout = function(){};

    $network.reconnect = function(callback) {

        $http({ 'method': 'JSON'
            , 'dataType': 'json'
            , 'params': {'loginKey':$network.loginKey}
            , 'url': configs.getAuthPath()
        })
            .success(function(result) {
                $network.token = result.token;
                localStorageService.set('token',result.token);
                $network.user = result.user;
                localStorageService.set('user',result.user);
                localStorageService.set('rights',result.rights);
                callback(true);
            })
            .error(function(data, status, headers, config) {
                $network.logout();
                window.location = '/login'
            });
    };
    $network.logout = function() {
        $network.token = false;
        localStorageService.set('token',false);
        localStorageService.set('currLang',false);
        $network.user = {};
        localStorageService.set('user',false);
        localStorageService.set('rights',false);
        $network.onLogout();
    };
    $network.isLogined = function() {
        var token = localStorageService.get('token');
        var time = localStorageService.get('tokenTime') - $.now();
        return  (token && token != 'false');
    };
    $network.connect = function(login, password, callback) {
        callback = callback || function(){};
        if (!$network.authProgress) {
            $network.authProgress = true;
            $network.loginKey = btoa(login + ':' + password);
            localStorageService.set('loginKey',$network.loginKey);
            $http({ 'method': 'JSON'
                , 'dataType': 'json'
                , 'params': {'loginKey':$network.loginKey}
                , 'url': configs.getAuthPath()
            })
                .success(function(result) {
                    $network.authProgress = false;
                    $network.token = result.token;
                    $network.user = result.user;
                    localStorageService.set('token',result.token);
                    localStorageService.set('tokenTime',$.now()+12*3600*1000);
                    localStorageService.set('user',result.user);
                    localStorageService.set('rights',result.rights);
                    callback(true, result);
                    $network.onLogin();
                })
                .error(function(data, status, headers, config) {
                    $network.authProgress = false;
                    callback(false, data);
                });
        }
    };

    $network.get = function(table, params, callback) {

        $network.servisePath = configs.getServisePath();
        var path = $network.servisePath  + table;
        var method = 'GET';
        var headers = {};

        $http.defaults.headers.common.Authorization = 'token ' + $network.token;
        $http.defaults.headers.get = {};
        $http.defaults.headers.get['Authorization'] = 'token ' + $network.token;
        $http.defaults.headers.common['Authorization'] = 'token ' + $network.token;
        headers = {'Authorization': $network.token};
        params = params || {};
        params.nc = new Date().getTime();
        $http({ 'method': method
            , 'params': params
            , 'headers': headers
            , 'url': path
        })
            .success(function(result) {
                callback(true, result);
            })
            .error(function(data, status, headers, config, statusText) {
                if(status == 401) {
                    $network.reconnect(function(result){
                        if(result) {
                            $network.get(table, params, callback);
                        } else {
                            // go to login
                            callback(false, data);
                        }
                    })
                } else {
                    if(data.system_code == 'ERR_INVALID_TOKEN') {
                        $network.logout();
                        window.location = '/login'
                    } else {
                        callback(false,data);
                    }
                }
            });

    };

    $network.post = function(table, params, callback) {
        callback = callback || function(){};
        $network.servisePath = configs.getServisePath();
        var path = $network.servisePath + table

        var headers = {};

        headers = {'Authorization': $network.token
            , 'Content-Type': 'application/x-www-form-urlencoded'
            , "Accept": "application/json; charset=utf-8"
        };

        $http({ 'method': 'POST'
            , 'headers': headers
            , 'dataType': 'json'
            , 'data': $.param(params)
            , 'url': path
        })
            .success(function(result) {
                callback(true, result);
            })
            .error(function(data, status, headers, config, statusText) {
                if(status == 401) {
                    $network.reconnect(function(result){
                        if(result) {
                            $network.post(table, params, callback)
                        } else {
                            callback(false, data)
                        }
                    })
                } else {
                    callback(false, data)
                }
            });

    };

    $network.put = function(table, params, callback) {
        callback = callback || function(){};
        $network.servisePath = configs.getServisePath();
        var path = $network.servisePath + table;

        var headers = {};

        headers = { 'Authorization': $network.token
            , 'Content-Type': 'application/json; charset=utf-8'
            , "Accept": "application/json; charset=utf-8"
        };

        $http({ 'method': 'PUT'
//          , 'params': params
            , 'headers': headers
            , 'dataType': 'json'
            , 'data': $.param(params)
            , 'url': path
        })
            .success(function(result) {
                callback(true, result);
            })
            .error(function(data, status, headers, config, statusText) {
                if(status == 401) {
                    $network.reconnect(function(result){
                        if(result) {
                            $network.put(table, params, callback)
                        } else {
                            callback(false, data)
                        }
                    })
                } else {
                    callback(false, data)
                }
            });

    };

    $network.delete = function(table, callback) {
        callback = callback || function(){};
        $network.servisePath = configs.getServisePath();
        var path = $network.servisePath + table;

        var headers = {};

        headers = {'Authorization': $network.token
            , 'Content-Type': 'application/x-www-form-urlencoded'
        };

        $http({ 'method': 'DELETE'
            , 'headers': headers
            , 'dataType': 'json'
            , 'url': path
        })
            .success(function(result) {
                callback(true, result);
            })
            .error(function(data, status, headers, config, statusText) {
                if(status == 401) {
                    $network.reconnect(function(result){
                        if(result) {
                            $network.delete(table, callback)
                        } else {
                            callback(false, data)
                        }
                    })
                } else {
                    callback(false, data)
                }
            });

    };

    //$network.sendSignUpMail = function(email, callback) {
    //
    //    var path = configs.getServisePath()+'mail';
    //    var method = 'GET';
    //
    //
    //
    //    $http({ 'method': method
    //        , 'url': path
    //        , 'params': {'email':email}
    //        , 'dataType': 'json'
    //    })
    //        .success(function(result, responce) {
    //            callback(true, responce);
    //        })
    //        .error(function(data, status, headers, config, statusText) {
    //            callback(false, data);
    //        });
    //
    //}
});
