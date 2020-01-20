angular.module('main', [])
.filter('moment', function () {
    return function (input, momentFn /*, param1, param2, ...param n */) {
        var args = Array.prototype.slice.call(arguments, 2),
            momentObj = moment(input);
        return momentObj[momentFn].apply(momentObj, args);
    };
})
.controller('EaController', ['$scope','$http','$timeout', function($scope,$http,$timeout) {

    $scope.step = 1;
    $scope.payment_form = 0;
    $scope.free = false;
    $scope.ea_comprovante_file = null;
    $scope.linkCheckout = '';
    $scope.userId = $("#user_id").val();

    $scope.renew = false;

    $scope.ea = {
        id : null,
        name : null
    };

    $scope.priceSelect = "Preço não selecionado!";

    $scope.contract = {
        payment_method: 0
    };

    /****** START EA SESSION ******/
    /****** START EA SESSION ******/
    /****** START EA SESSION ******/
    $scope.eas = [];

    $scope.loadEas = function()
    {
        $.ajax({
            url: '/api/ea',
            type: "GET",
            async: false,
            data: {
                'filter': [
                    {
                        'field': 'active',
                        'where': 'AND',
                        'type': 'eq',
                        'value': 1
                    },
                    {
                        'field': 'type',
                        'where': 'AND',
                        'type': 'eq',
                        'value': 0
                    }
                ]
            },
            success: function (o) {
                $scope.eas = o._embedded.ea;
            }
        });
    };

    $scope.mirrors = [];

    $scope.loadMirrorings = function()
    {
        $.ajax({
            url: '/api/ea',
            type: "GET",
            async: false,
            data: {
                'filter': [
                    {
                        'field': 'active',
                        'where': 'AND',
                        'type': 'eq',
                        'value': 1
                    },
                    {
                        'field': 'type',
                        'where': 'AND',
                        'type': 'eq',
                        'value': 1
                    }
                ]
            },
            success: function (o) {
                $scope.mirrors = o._embedded.ea;
            }
        });
    };

    /****** END EA SESSION ******/
    /****** END EA SESSION ******/
    /****** END EA SESSION ******/

    /****** START PRICE SESSION ******/
    /****** START PRICE SESSION ******/
    /****** START PRICE SESSION ******/
    $scope.prices = [];

    $scope.loadPrices = function()
    {
        if($scope.ea.id) {
            let filter = null;
            if($scope.contract.id != null){
                filter = [
                    {
                        'field': 'ea',
                        'where': 'AND',
                        'type': 'eq',
                        'value': $scope.ea.id
                    },
                    {
                        'field': 'first',
                        'where': 'AND',
                        'type': 'eq',
                        'value': 0
                    }
                ];
            }else{
                filter = [
                    {
                        'field': 'ea',
                        'where': 'AND',
                        'type': 'eq',
                        'value': $scope.ea.id
                    },
                    {
                        'field': 'first',
                        'where': 'AND',
                        'type': 'eq',
                        'value': 1
                    }
                ];
            }

            $.ajax({
                url: '/api/ea-price',
                type: "GET",
                async: false,
                data: {
                    'filter': filter
                },
                success: function (o) {
                    $scope.prices = o._embedded.ea_price;
                }
            });
        }else{
            $scope.prices = [];
        }
    };
    /****** END PRICE SESSION ******/
    /****** END PRICE SESSION ******/
    /****** END PRICE SESSION ******/

    /****** START ACCOUNT SESSION ******/
    /****** START ACCOUNT SESSION ******/
    /****** START ACCOUNT SESSION ******/
    $scope.accounts = [];

    $scope.add_account_btn      = true;
    $scope.update_account_btn   = false;
    $scope.cancel_account_btn   = false;

    $scope.account_obj = {
        id      :   null,
        number  :   null,
        password :   null,
        server :   null,
        user    :   $scope.userId
    };

    $scope.loadAccounts = function()
    {
        $.ajax({
            url: '/api/eaxm-account',
            type: "GET",
            async: false,
            data: {
                'filter': [
                    {
                        'field': 'user',
                        'where': 'AND',
                        'type': 'eq',
                        'value': $scope.userId
                    }
                ]
            },
            success: function (o) {
                $scope.accounts = o._embedded.eaxm_account;
                $timeout(function () {
                    if ($scope.accounts.length > 0) {
                        for (i in $scope.accounts) {
                            delete $scope.accounts[i].contracts;
                            $scope.accounts[i].contracts = [];
                        }

                        for (i in $scope.accounts) {
                            var account = $scope.accounts[i];

                            $.ajax({
                                url: '/api/ea-contract',
                                type: "GET",
                                async: false,
                                data: {
                                    'filter': [
                                        {
                                            'field': 'ea_xm_account',
                                            'where': 'AND',
                                            'type': 'eq',
                                            'value': account.id
                                        }
                                    ]
                                },
                                success: function (o) {

                                    var contracts = o._embedded.ea_contract;
                                    if(contracts.length > 0){
                                        delete $scope.accounts[i].contracts;
                                        $scope.accounts[i].contracts = contracts;
                                    }

                                }
                            });
                        }
                    }
                },300);
            }
        });

        $timeout(function () {
            console.log($scope.accounts);
        },5000);
    };

    $scope.add_account = function()
    {
        let is_valid = $scope.validate_account();

        if(is_valid){
            $http({
                url: '/api/eaxm-account',
                method: "POST",
                data: $scope.account_obj
            }).then(function (response) {
                    $.smallBox({
                        title : "Sucesso!",
                        content : "<i class='fa fa-clock-o'></i> <i>Conta cadastrada com sucesso!</i>",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $scope.loadAccounts();
                    $scope.clearAccount();
                },
                function (response) {
                    $.smallBox({
                        title : "Ocorreu um erro!",
                        content : "<i class='fa fa-clock-o'></i> <i>Aconteceu algum erro ao cadastrar registro, erro: "+response.statusText+"</i>",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                });
        }else{
            return false
        }
    };

    $scope.update_account = function(id)
    {
        let is_valid = $scope.validate_account();

        var data = $scope.account_obj;

        delete data.id;
        delete data.user;

        if(is_valid){
            $http({
                url: "/api/eaxm-account/"+id,
                method: "PATCH",
                data: data
            }).then(function (response) {
                    $.smallBox({
                        title : "Sucesso!",
                        content : "<i class='fa fa-clock-o'></i> <i>Conta atualizada com sucesso!</i>",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $scope.loadAccounts();
                    $scope.clearAccount();
                    $scope.add_account_btn      = true;
                    $scope.update_account_btn   = false;
                    $scope.cancel_account_btn   = false;
                },
                function (response) {
                    $.smallBox({
                        title : "Ocorreu um erro!",
                        content : "<i class='fa fa-clock-o'></i> <i>Aconteceu algum erro ao atualizar o registro, erro: "+response.statusText+"</i>",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                });
        }else{
            return false
        }
    };

    $scope.cancel_account = function()
    {
        $scope.add_account_btn      = true;
        $scope.update_account_btn   = false;
        $scope.cancel_account_btn   = false;
        $scope.clearAccount();
    };

    $scope.edit_account = function(id)
    {
        $http({
            url: '/api/eaxm-account/'+id,
            method: "GET",
            async: false,
        }).then(function (response) {
                let account = response.data;
                $scope.account_obj = {
                    id      :   account.id,
                    number  :   Number(account.number),
                    password    :   account.password,
                    server    :   account.server,
                    user    :   account._embedded.user.id
                };

                $scope.add_account_btn      = false;
                $scope.update_account_btn   = true;
                $scope.cancel_account_btn   = true;
            },
            function (response) {
                $.smallBox({
                    title : "Ocorreu um erro!",
                    content : "<i class='fa fa-clock-o'></i> <i>Aconteceu algum erro ao buscar o registro, erro: "+response.statusText+"</i>",
                    color : "#C46A69",
                    iconSmall : "fa fa-times fa-2x fadeInRight animated",
                    timeout : 4000
                });
            });
    };

    $scope.del_account = function(id)
    {
        bootbox.confirm({
            message: "Você deseja realmente excluir esse registro?",
            buttons: {
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                },
                confirm: {
                    label: 'Sim',
                    className: 'btn-success btnConfirm',
                }
            },
            callback: function (result) {
                if(!result){
                    this.modal('hide');
                }else{
                    $.ajax({
                        url: '/api/eaxm-account/' + id,
                        type: "DELETE",
                        async: false,
                        success: function (o) {
                            $.smallBox({
                                title : "Sucesso!",
                                content : "<i class='fa fa-clock-o'></i> <i>Você deletou o registro!</i>",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 4000
                            });

                            $timeout(function(){
                                $scope.loadAccounts();
                                $("#tab_accounts").trigger('click');
                                this.modal('hide');
                            },300);
                        },
                        error: function(o) {
                            $.smallBox({
                                title : "Ocorreu um erro!",
                                content : "<i class='fa fa-clock-o'></i> <i>Aconteceu algum erro ao tentar excluir o registro, por favor, entre em contato com o administrador!</i>",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                                timeout : 10000
                            });
                            this.modal('hide');
                        }
                    });
                }
            }
        });
    };

    $scope.validate_account = function()
    {
        let error = 0;
        if(!$scope.account_obj.number)
        {
            $.smallBox({
                title : "Anteção!",
                content : '<i class="fa fa-warning"></i> Você precisa preencher o campo "Número da Conta"',
                color : "#C46A69",
                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                timeout : 10000
            });

            error++;
        }

        if(!$scope.account_obj.password)
        {
            $.smallBox({
                title : "Anteção!",
                content : '<i class="fa fa-warning"></i> Você precisa preencher o campo "Senha"',
                color : "#C46A69",
                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                timeout : 10000
            });

            error++;
        }

        if(!$scope.account_obj.server)
        {
            $.smallBox({
                title : "Anteção!",
                content : '<i class="fa fa-warning"></i> Você precisa preencher o campo "Server"',
                color : "#C46A69",
                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                timeout : 10000
            });

            error++;
        }

        if(error > 0)
        {
            return false;
        }else{
            return true;
        }
    };

    $scope.clearAccount = function()
    {
        $scope.account_obj = {
            id      :   null,
            number  :   null,
            password    :   null,
            server    :   null,
            user    :   $scope.userId
        };
    };
    /****** END ACCOUNT SESSION ******/
    /****** END ACCOUNT SESSION ******/
    /****** END ACCOUNT SESSION ******/

    /****** START CONTRACTS SESSION ******/
    /****** START CONTRACTS SESSION ******/
    /****** START CONTRACTS SESSION ******/
    $scope.contracts = [];
    $scope.ea_contract_btn = true;
    $scope.ea_contract_btn_disable = false;

    $scope.loadContracts = function()
    {
        $.ajax({
            url: '/api/ea-contract',
            type: "GET",
            async: false,
            data: {
                'filter': [
                    {
                        'field': 'user',
                        'where': 'AND',
                        'type': 'eq',
                        'value': $scope.userId
                    }
                ]
            },
            success: function (o) {
                $scope.contracts = o._embedded.ea_contract;
                console.log($scope.contracts);
            }
        });
    };

    $scope.contracting = function(ea)
    {
        $scope.step = 1;
        $scope.renew = false;
        $scope.clear();

        if($scope.accounts.length < 1){
            $("#tab_accounts").trigger('click');

            $.smallBox({
                title : "Anteção!",
                content : "<i class='fa fa-clock-o'></i> <i>Você precisa ter uma conta na Activtrades para poder contratar um Serviço!</i>",
                color : "#C46A69",
                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                timeout : 10000
            });
        }

        $scope.ea = ea;
        $scope.contract = {};

        $scope.loadPrices();

        $("#eaModal").modal();
    };

    $scope.faturas = [];
    $scope.total_fatura = 0;
    $scope.loadFaturas = function()
    {
        $.ajax({
            url: '/api/ea-request-payment',
            type: "GET",
            async: false,
            data: {
                'filter': [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            { 'type' : 'eq', 'field' : 'ea_contract', 'value' : $scope.contract.id },
                            { 'type' : 'neq', 'field' : 'paid_out', 'value' : 1 }
                        ],
                        'where' : 'and'
                    }
                ]
            },
            success: function (o) {
                $timeout(function(){
                    $scope.faturas = o._embedded.ea_request_payment;
                    for(i in $scope.faturas){
                        $scope.faturas[i].value *= Number($("#cotacao").val());
                        $scope.total_fatura += $scope.faturas[i].value;
                        $scope.faturas[i].rendimento_total = $scope.faturas[i].value * 100 / 35;
                        $scope.faturas[i].rendimento_liquido = $scope.faturas[i].rendimento_total - $scope.faturas[i].value;
                    }
                });
            }
        });
    };

    $scope.contractingUpdate = function(contract,renew)
    {
        $scope.step = 2;
        // $scope.payment_form = contract.payment_method;
        // $scope.free = contract._embedded.ea_price.free;
        $scope.renew = renew;
        $scope.clear();

        if($scope.accounts.length < 1){
            $("#tab_accounts").trigger('click');

            $.smallBox({
                title : "Anteção!",
                content : "<i class='fa fa-clock-o'></i> <i>Você precisa ter uma conta na Activtrades para poder contratar um Expert Advisor!</i>",
                color : "#C46A69",
                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                timeout : 10000
            });
        }

        $scope.ea = contract._embedded.ea;
        $scope.contract = contract;
        $scope.loadFaturas();
        //$scope.loadPrices();

        $("#eaModal").modal();
    };

    $scope.add = function() {

        var formData = new FormData(document.getElementById("ea_contract_form"));

        $scope.ea_contract_btn = false;
        $scope.ea_contract_btn_disable = true;

        if($scope.payment_form == 0 && $scope.contract.id && $scope.free != 1){
            var f = document.getElementById('ea_comprovante_file').files[0],
                r = new FileReader();

            r.onloadend = function(e) {
                var data = e.target.result;
                if($scope.payment_form == 0) {
                    var ext = f.name.substring(f.name.indexOf(".") + 1);
                    formData.append('file', data);
                }

                $scope.sendAdd(formData);
            };

            r.readAsBinaryString(f);
        }else{
            $scope.sendAdd(formData);
        }

        return false;
    };

    $scope.sendAdd = function(formData){
        $.ajax({
            url: '/admin-modulo/ea-contract-save',
            type: 'POST',
            data:  formData,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(result, textStatus, jqXHR)
            {
                var result_obj = JSON.parse(result);
                var r = result_obj.result;
                var message = JSON.parse(result).message;
                if(r){
                    $.smallBox({
                        title : "Sucesso!",
                        content : "<i class='fa fa-clock-o'></i> <i>"+message+"</i>",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $timeout(function(){
                        $.smallBox({
                            title : "Sucesso!",
                            content : "<i class='fa fa-clock-o'></i> <i>Vamos analisar a sua solicitação, em breve entraremos em contato!</i>",
                            color : "#659265",
                            iconSmall : "fa fa-check fa-2x fadeInRight animated",
                            timeout : 8000
                        });
                    },1500);

                    $("#eaModal").modal('hide');
                    $scope.load();
                }else{
                    $.smallBox({
                        title : "Ocorreu um erro!",
                        content : "<i class='fa fa-clock-o'></i> <i>"+message+"</i>",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 10000
                    });
                }

                $scope.ea_contract_btn = true;
                $scope.ea_contract_btn_disable = false;

            },
            error: function (result) {
                $.smallBox({
                    title : "Ocorreu um erro!",
                    content : "<i class='fa fa-clock-o'></i> <i>Aconteceu algum erro ao enviar a solicitação de contrato, por favor, entre em contato com o administrador!</i>",
                    color : "#C46A69",
                    iconSmall : "fa fa-times fa-2x fadeInRight animated",
                    timeout : 10000
                });

                $scope.ea_contract_btn = true;
                $scope.ea_contract_btn_disable = false;
            }
        });
    };

    $scope.del = function(id)
    {
        bootbox.confirm({
            message: "Você deseja realmente excluir esse registro?",
            buttons: {
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                },
                confirm: {
                    label: 'Sim',
                    className: 'btn-success btnConfirm',
                }
            },
            callback: function (result) {
                if(!result){
                    this.modal('hide');
                }else{
                    $.ajax({
                        url: '/api/ea-contract/' + id,
                        type: "DELETE",
                        async: false,
                        success: function (o) {
                            $.smallBox({
                                title : "Sucesso!",
                                content : "<i class='fa fa-clock-o'></i> <i>Você deletou o registro!</i>",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 4000
                            });

                            $timeout(function(){
                                $scope.loadContracts();
                                this.modal('hide');
                            },300);
                        },
                        error: function(o) {
                            $.smallBox({
                                title : "Ocorreu um erro!",
                                content : "<i class='fa fa-clock-o'></i> <i>Aconteceu algum erro ao tentar excluir o registro, por favor, entre em contato com o administrador!</i>",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                                timeout : 10000
                            });
                            this.modal('hide');
                        }
                    });
                }
            }
        });
    };
    /****** END CONTRACTS SESSION ******/
    /****** END CONTRACTS SESSION ******/
    /****** END CONTRACTS SESSION ******/

    $scope.load = function() {
        $scope.loadEas();
        $scope.loadMirrorings();
        $scope.loadAccounts();
        $scope.loadContracts();
    };

    $scope.load();

    $scope.clear = function() {
        $scope.clearAccount();
        $scope.add_conta_btn = true;
        $scope.save_conta_btn = false;
    };

    $scope.getPercent = function(dt_start,db_finish)
    {
        var result = {};
        if(dt_start && db_finish) {
            var date = new Date();
            var date_start = new Date(dt_start.date);
            var date_finish = new Date(db_finish.date);

            var percent = "";

            if (date < date_start) {

                var timeDiff = Math.abs(date_start.getTime() - date_finish.getTime());
                var totDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                result.percent = 100;
                result.dias = 0;
                result.restantes = totDays;

            } else if (date > date_start && date < date_finish) {

                var timeDiff = Math.abs(date_start.getTime() - date_finish.getTime());
                var totDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                var timeDiff = Math.abs(date_start.getTime() - date.getTime());
                var currentDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                result.percent = 100 - ((currentDays * 100) / totDays).toFixed(2);
                result.dias = currentDays;
                result.restantes = totDays - currentDays;

            } else if (date > date_finish) {
                result.percent = 0;
                result.dias = 0;
                result.restantes = 0;
            }

            return result;
        }else{
            result.percent = 100;
            result.dias = 0;
            result.restantes = 0;
            return result;
        }
    };

    $scope.getStatus = function(status,dt_start,dt_finish)
    {
        if(!dt_start || !dt_finish){
            return "Pendente";
        }

        var date = new Date();
        var date_start  = new Date(dt_start.date);
        var date_finish = new Date(dt_finish.date);

        var situation = "";

        switch (status) {
            case 0: //Pendente
                situation = "Pendente";
                break;
            case 1: //Ativo
                if(date < date_start){
                    situation = "A Iniciar";
                }else if(date > date_start && date < date_finish){
                    situation = "Em processo";
                }else if(date > date_finish){
                    situation = "Finalizado";
                }
                break;
            case 2: //Cancelado
                situation = "Cancelado";
                break;
        }

        return situation;
    };

    $scope.formatDate = function(dt)
    {
        if(dt != '') {
            var date = new Date(dt.date);
            return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
        }else{
            return '';
        }
    };
    
    $scope.appearTabAccount = function () {
        $("#tab_s2").trigger('click');
    }

    $scope.getTypeService = function(type){
        var typeStr = '';

        switch (type) {
            case 0:
                typeStr = 'Expert Advisor';
                break;
            case 1:
                typeStr = 'Espelhamento';
                break;
            default:
                typeStr = 'Expert Advisor';
                break;
        }

        return typeStr;
    }

    $scope.selectPrice = function (price_id) {

        $.ajax({
            url: '/api/ea-price/' + price_id,
            type: "GET",
            async: false,
            success: function (o) {
                let price = o;

                $timeout(function () {
                    $scope.priceSelect = price.title + " por " + numberToReal(price.price);
                    $scope.free = price.free;
                    $scope.linkCheckout = price.link_checkout;
                },300);
            }
        });
    };

    $scope.emptyContracts = function (account_id) {
      return false;
    };

    $scope.selectPaymentForm = function (payment_form) {
        $scope.payment_form = payment_form;
        $scope.contract.payment_method = $scope.payment_form;
        $scope.nextStep();
    };

    $scope.previousStep = function () {
        $scope.step--;
    };

    $scope.nextStep = function () {
        $scope.step++;
    };

    function numberToReal(numero) {
        var numero = numero.toFixed(2).split('.');
        numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
        return numero.join(',');
    };
}])
.controller('RequestPaymentController', ['$scope','$http','$timeout', function($scope,$http,$timeout) {
    $scope.yields = [];
    $scope.yields_page = 1;
    $scope.yields_pages = 1;
    $scope.yields_total_pages = 1;

    $scope.requests = [];
    $scope.requests_page = 1;
    $scope.requests_pages = 1;
    $scope.requests_total_pages = 1;

    $scope.yield = {
        id: null,
        mes: (new Date()).getUTCMonth() + 1,
        ano: (new Date()).getUTCFullYear()
    };

    $scope.clear = function() {
        $scope.yield = {
            id: null,
            mes: (new Date()).getUTCMonth() + 1,
            ano: (new Date()).getUTCFullYear(),
            percentual: 0,
            fechado: false
        };
    };

    $scope.save = function(evt) {
        evt.preventDefault();

        bootbox.confirm({
            message: "Você deseja realmente aplicar esse rendimento?",
            buttons: {
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                },
                confirm: {
                    label: 'Sim',
                    className: 'btn-success btnConfirm',
                }
            },
            callback: function (result) {
                if(!result){
                    this.modal('hide');
                }else{
                    $.ajax({
                        url: '/admin-module/yield-save' ,
                        type: 'post',
                        dataType : "json",
                        data: $scope.yield,
                        success: function (o) {
                            $scope.loadYields($scope.yields_page);
                            $scope.loadRequests();
                            $scope.clear();
                            $.smallBox({
                                title : "Sucesso!",
                                content : "<i class='fa fa-clock-o'></i> <i>&nbsp;O rendimento foi aplicado com sucesso!</i>",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 4000
                            });

                        },
                        error: function () {
                            $.smallBox({
                                title : "Ocorreu um erro!",
                                content : "<i class='fa fa-clock-o'></i> <i> Erro ao salvar o rendimento!</i>",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                                timeout : 4000
                            });
                        }
                    });
                }
            }
        });
    };

    $scope.numberArray = function(number){
        var arr = [];

        for(var i = 1; i <= number; i++){
            arr.push(i);
        }

        return arr
    };

    $scope.prevYields = function() {
      if($scope.yields_page > 1){
          $scope.loadYields(--$scope.yields_page);
      }
    };

    $scope.nextYields = function() {
        if($scope.yields_page < $scope.yields_total_pages){
            $scope.loadYields(++$scope.yields_page);
        }
    };

    $scope.loadYields = function(page = 1) {
        $scope.yields_page = page;
        $.ajax({
            url: `/api/ea-yield?page=${ page }`,
            type: "GET",
            async: false,
            data: {
                'filter': [],
                'order-by' : [
                    {
                        'type' : 'field',
                        'field' : 'ano',
                        'direction' : 'desc'
                    },
                    {
                        'type' : 'field',
                        'field' : 'mes',
                        'direction' : 'desc'
                    }
                ]
            },
            success: function (o) {
                $timeout(function(){
                    $scope.yields_pages = $scope.numberArray(o.page_count);
                    $scope.yields_total_pages = o.page_count;
                    $scope.yields = o._embedded.ea_yield;
                });
            }
        });
    };
    $scope.loadYields();

    $scope.filterContract = {
      nome: "",
      contract: ""
    };

    $scope.filterContracts = function () {
        evt.preventDefault();
        console.log('filtrando');
    };

    $scope.loadRequests = function(page = 1) {
        $scope.requests_page = page;
        $.ajax({
            url: `/api/ea-request-payment?page=${ page }`,
            type: "GET",
            async: false,
            data: {
                'filter': [],
                'order-by' : [
                    {
                        'type' : 'field',
                        'field' : 'paid_out',
                        'direction' : 'asc'
                    },
                    {
                        'type' : 'field',
                        'field' : 'due_date',
                        'direction' : 'desc'
                    }
                ]
            },
            success: function (o) {
                $timeout(function(){
                    $scope.requests_pages = $scope.numberArray(o.page_count);
                    $scope.requests_total_pages = o.page_count;
                    $scope.requests = o._embedded.ea_request_payment;
                });
            }
        });
    };

    $scope.loadRequests();

    $scope.prevRequests = function() {
        if($scope.requests_page > 1){
            $scope.loadRequests(--$scope.requests_page);
        }
    };

    $scope.nextRequests = function() {
        if($scope.requests_page < $scope.requests_total_pages){
            $scope.loadRequests(++$scope.requests_page);
        }
    };

    $scope.request_selected = null;
    $scope.valor_na_contratacao = 0;
    $scope.valor_atual = 0;
    $scope.rendimento_total = 0;
    $scope.rendimento_liquido = 0;
    $scope.valor_cobrado = 0;
    $scope.btn_send = true;
    $scope.btn_save = true;

    $scope.modalRequest = function (request) {

        $scope.request_selected = request.id;
        $scope.valor_cobrado = request.value;
        //Valor cobrado é 35% de qual nº?
        $scope.rendimento_total = ($scope.valor_cobrado > 0) ? $scope.valor_cobrado * 100 / 35 : 0;
        $scope.rendimento_liquido = $scope.rendimento_total - $scope.valor_cobrado;

        $scope.valor_na_contratacao = request._embedded.ea_contract.value_in_account;
        $scope.valor_atual = $scope.valor_na_contratacao + $scope.rendimento_total;
        $scope.valor_na_contratacao = floatToMoeda($scope.valor_na_contratacao);
        $scope.valor_atual = floatToMoeda($scope.valor_atual);
    };

    $scope.calculaFatura = function () {
        $scope.rendimento_total = moedaToFloat($scope.valor_atual) - moedaToFloat($scope.valor_na_contratacao);
        $scope.rendimento_liquido = $scope.rendimento_total * 0.65;
        $scope.valor_cobrado = $scope.rendimento_total * 0.35;
    };

    $scope.saveRequest = function () {
        $scope.btn_save = false;
        $.ajax({
            url : `/api/ea-request-payment/${ $scope.request_selected }`,
            data: JSON.stringify({ value : $scope.valor_cobrado }),
            type : 'PATCH',
            contentType : 'application/json',
            success: function (o) {
                $timeout(function(){
                    $scope.loadRequests();
                    $scope.btn_save = true;
                    $.smallBox({
                        title : "Sucesso!",
                        content : "<i class='fa fa-clock-o'></i> <i>&nbsp;O calculo foi salvo com sucesso!</i>",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                });
            },
            error: function () {
                $scope.btn_save = true;
                $.smallBox({
                    title : "Ocorreu um erro!",
                    content : "<i class='fa fa-clock-o'></i> <i> Erro ao salvar o calculo!</i>",
                    color : "#C46A69",
                    iconSmall : "fa fa-times fa-2x fadeInRight animated",
                    timeout : 4000
                });

            }
        });
    };

    $scope.sendMailRequest = function() {
        $scope.btn_send = false;
        $.ajax({
            url : `/api/ea-request-payment/${ $scope.request_selected }`,
            data: JSON.stringify({ value : $scope.valor_cobrado }),
            type : 'PATCH',
            contentType : 'application/json',
            success: function (o) {
                $timeout(function(){
                    $.ajax({
                        url: '/admin-module/send-mail-request-payment' ,
                        type: 'post',
                        dataType : "json",
                        data: { id : $scope.request_selected, value_in_account : $scope.valor_na_contratacao },
                        success: function (o) {
                            $timeout(function(){
                                $.smallBox({
                                    title : "Sucesso!",
                                    content : "<i class='fa fa-clock-o'></i> <i>&nbsp;Cobrança enviada com sucesso!</i>",
                                    color : "#659265",
                                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                    timeout : 4000
                                });

                                $scope.btn_send = true;
                            });
                        },
                        error: function () {
                            $.smallBox({
                                title : "Ocorreu um erro!",
                                content : "<i class='fa fa-clock-o'></i> <i> Erro ao enviar a cobrança</i>",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                                timeout : 4000
                            });
                            $scope.btn_send = true;
                        }
                    });
                });
            },
            error: function () {
                $.smallBox({
                    title : "Ocorreu um erro!",
                    content : "<i class='fa fa-clock-o'></i> <i> Erro ao enviar o email!</i>",
                    color : "#C46A69",
                    iconSmall : "fa fa-times fa-2x fadeInRight animated",
                    timeout : 4000
                });
                $scope.btn_send = true;
            }
        });

    }

    }])
.controller('MyfxController', ['$scope','$http','$timeout', function($scope,$http,$timeout) {

    $scope.user = {
        id: null,
        username: '',
        password: '',
        session: ''
    };

    $scope.accounts = [];
    $scope.account = '';

    $scope.signInMyfx = function() {
        let uri = "/admin-module/configuration-myfx/sigin";
        $.ajax({
            url: uri ,
            type: "POST",
            async: false,
            data: {'user' : $scope.user},
            success: function (o) {
                var response = JSON.parse(o);
                if(response.error){
                    $.smallBox({
                        title : "Ocorreu um erro!",
                        content : "<i class='fa fa-clock-o'></i> <i> Usuário ou senha incorreta!</i>",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }else{
                    $scope.user.id = response.id;
                    $scope.user.session = response.session;
                    $("#myfx-username").attr('readonly','readonly');
                    $("#myfx-password").attr('readonly','readonly');

                    $scope.getAccounts();
                }
            }
        });
    };

    $scope.signOutMyfx = function() {
        $scope.user = {
            id: null,
            username: '',
            password: '',
            session: ''
        };

        $scope.accounts = [];

        $("#myfx-username").removeAttr('readonly');
        $("#myfx-password").removeAttr('readonly');
    };

    $scope.testXmAccount = function() {
        let uri = "/admin-module/configuration-myfx/sigin";
        $.ajax({
            url: uri ,
            type: "POST",
            async: false,
            data: {'user' : $scope.user},
            success: function (o) {
                var response = JSON.parse(o);
                if(response.error){
                    $.smallBox({
                        title : "Ocorreu um erro!",
                        content : "<i class='fa fa-clock-o'></i> <i> Usuário ou senha incorreta!</i>",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }else{
                    $scope.user.id = response.id;
                    $scope.user.session = response.session;
                    $("#myfx-username").attr('readonly','readonly');
                    $("#myfx-password").attr('readonly','readonly');
                }
            }
        });
    };

    $scope.getAccounts = function() {
        let uri = "/admin-module/configuration-myfx/get-accounts";
        $.ajax({
            url: uri ,
            type: "POST",
            async: false,
            data: {'session' : $scope.user.session},
            success: function (o) {
                var response = JSON.parse(o);
                if(response.error){
                    $.smallBox({
                        title : "Ocorreu um erro!",
                        content : "<i class='fa fa-clock-o'></i> <i> Erro ao listar as contas</i>",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }else{
                    for(account in response.accounts)
                    {
                        $scope.accounts.push(response.accounts[account]);
                    }
                }
            }
        });
    }

    $scope.addGraph = function(account) {
        let uri = "/admin-module/graph-performance/save";
        $.ajax({
            url: uri ,
            type: "POST",
            async: false,
            data: {'account' : account,'configuration' : $scope.user.id },
            success: function (o) {
                var response = JSON.parse(o);
                if(response.result){
                    $.smallBox({
                        title : "Sucesso!",
                        content : "<i class='fa fa-clock-o'></i> <i>&nbsp;A conta está disponível para análise!</i>",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    setTimeout(function(){
                        location.reload();
                    },1500);
                }
            }
        });
    }
}]);

function getStatus(status,dt_start,db_finish)
{
    var date = new Date();
    var date_start  = new Date(dt_start.date);
    var date_finish = new Date(db_finish.date);

    var situation = "";

    switch (status) {
        case 0: //Pendente
            situation = "Pendente";
            break;
        case 1: //Ativo
            if(date < date_start){
                situation = "A Iniciar";
            }else if(date > date_start && date < date_finish){
                situation = "Em processo";
            }else if(date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear() == date_finish.getDate() + '/' + date_finish.getMonth() + '/' + date_finish.getFullYear()){
                situation = "A Expirar";
            }else if(date > date_finish){
                situation = "Finalizado";
            }
            break;
        case 2: //Cancelado
            situation = "Cancelado";
            break;
    }

    console.log(situation);
    return situation;
}

$(document).ready(function () {
    $(".row_ea-contract_line").each(function () {
        var id = this.id;
        id = id.replace('row_','');
        var class_str = $(this).attr('class');
        $.ajax({
            url: '/api/ea-contract/' + id,
            type: "GET",
            async: false,
            success: function (o) {
                var contract = o;

                setTimeout(function () {
                    var class_color = "";

                    if((contract.date_start && contract.date_start !== undefined) && (contract.date_finish && contract.date_finish !== undefined)){

                        switch (getStatus(contract.status,contract.date_finish,contract.date_finish)) {
                            case "Pendente":
                                class_color = "bg-warning";
                                break;
                            case "A Iniciar":
                                class_color = "bg-success";
                                break;
                            case "Em processo":
                                class_color = "bg-success";
                                break;
                            case "A Expirar":
                                class_color = "bg-color-pink";
                                break;
                            case "Finalizado":
                                class_color = "bg-danger";
                                break;
                            case "Cancelado":
                                class_color = "bg-dark";
                                break;
                        }
                    }else{
                        class_color = "bg-warning";
                    }

                    $("#row_" + id).attr('class',class_str + " " + class_color);

                },300);
            }
        });
    });

    $(".row_blacklist-espelhamento_line").each(function () {
        var id = this.id;
        id = id.replace('row_','');
        var class_str = $(this).attr('class');
        $.ajax({
            url: '/api/ea-contract/' + id,
            type: "GET",
            async: false,
            success: function (o) {
                var contract = o;

                setTimeout(function () {
                    var class_color = "";

                    if((contract.date_start && contract.date_start !== undefined) && (contract.date_finish && contract.date_finish !== undefined)){

                        switch (getStatus(contract.status,contract.date_finish,contract.date_finish)) {
                            case "Pendente":
                                class_color = "bg-warning";
                                break;
                            case "A Iniciar":
                                class_color = "bg-success";
                                break;
                            case "Em processo":
                                class_color = "bg-success";
                                break;
                            case "A Expirar":
                                class_color = "bg-color-pink";
                                break;
                            case "Finalizado":
                                class_color = "bg-danger";
                                break;
                            case "Cancelado":
                                class_color = "bg-dark";
                                break;
                        }
                    }else{
                        class_color = "bg-warning";
                    }

                    $("#row_" + id).attr('class',class_str + " " + class_color);

                },300);
            }
        });
    });
});

