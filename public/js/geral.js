
$(document).ready(function(){

    $("#Inputqtd_month").blur(function(){
    	if(Number($("#Inputqtd_month").val()) > 0) {
            var months = Number($("#Inputqtd_month").val());
            var today = new Date();
            var date = new Date(today.getFullYear(), today.getMonth() + months, today.getDate());

            // var today = today.toLocaleDateString("en-US");
            // var date = date.toLocaleDateString("en-US");
            var today = today.toISOString().slice(0,10);
            var date = date.toISOString().slice(0,10);

            $("#Inputdate_start").val(today);
            $("#Inputdate_finish").val(date);
        }
    });

    $("#Inputdate_start").blur(function(){
        if(Number($("#Inputqtd_month").val()) == 0){
            $("#Inputqtd_month").val(1);
		}

		if($("#Inputdate_start").val() != ''){
            var months = Number($("#Inputqtd_month").val());
            var date_start = new Date($("#Inputdate_start").val());
            var date_finish = new Date(date_start.getFullYear(), date_start.getMonth() + months, date_start.getDate());

            var date_start = date_start.toISOString().slice(0,10);
            var date_finish = date_finish.toISOString().slice(0,10);

            $("#Inputdate_start").val(date_start);
            $("#Inputdate_finish").val(date_finish);

		}


        // if(Number($("#Inputqtd_month").val()) > 0) {
        //     var months = Number($("#Inputqtd_month").val());
        //     var today = new Date();
        //     var date = new Date(today.getFullYear(), today.getMonth() + months, today.getDate());
		//
        //     // var today = today.toLocaleDateString("en-US");
        //     // var date = date.toLocaleDateString("en-US");
        //     var today = today.toISOString().slice(0,10);
        //     var date = date.toISOString().slice(0,10);
		//
        //     $("#Inputdate_start").val(today);
        //     $("#Inputdate_finish").val(date);
        // }
    });

	//Página de registro
	var erro=0;
	$("input[name=confirmation]").blur(function(){		
		erro = verifySenha(erro);		
	});

	function verifySenha(erro){		
		
		if($("input[name=confirmation]").val() != $(".authPass").val()){
			$("input[name=confirmation]").val('');
			$(".confirmation-alert").fadeIn('fast');
			setTimeout(function(){
				$(".confirmation-alert").fadeOut('fast');
			},3000);
		}
		
		erro++;
		return erro;
	}	
	
	$(".telefone")
	.mask("(99) 9999-9999?9")
	.focusout(function (event) {  
	    var target, phone, element;  
	    target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
	    phone = target.value.replace(/\D/g, '');
	    element = $(target);  
	    element.unmask();  
	    if(phone.length > 10) {  
	        element.mask("(99) 99999-999?9");  
	    } else {  
	        element.mask("(99) 9999-9999?9");  
	    }  
	});

});

function saveAccountXm(id) {
	var account = $("#account_xm_" + id).val();
	var password = $("#password_xm_" + id).val();
	var server = $("#server_xm_" + id).val();

    data = JSON.stringify({
		'number' : account,
		'password' : password,
		'server' : server
    });

    $.ajax({
        url: '/api/eaxm-account/' + id,
        type: "PATCH",
        async: true,
        contentType : 'application/json',
        data: data,
        success: function (o) {
            $.smallBox({
                title : "Sucesso!",
                content : "<i class='fa fa-clock-o'></i> <i>Conta salva com sucesso!</i>",
                color : "#659265",
                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                timeout : 4000
            });
        },
        error: function (o) {
            $.smallBox({
                title : "Ocorreu um erro!",
                content : "<i class='fa fa-clock-o'></i> <i>Aconteceu algum erro ao tentar salvar a conta!</i>",
                color : "#C46A69",
                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                timeout : 10000
            });
        },
        dataType: "json"
    });
}

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

$(document).ready(function(){

	$("#content").css('min-height',$("#left-panel").height()+"px");

    $("#Inputfree").change(function(){
        if($(this).val()==1){
            $("input").each(function(){
            	if($(this).attr('required') == 'required')
				{
					$(this).removeAttr('required');
                }
            });
            $("#InputVitalicio").parent().parent().hide();
            $("#InputMensagemRestricao").parent().parent().hide();
            $(".bx-not-free").hide();
        }else{
            $("input").each(function(){
                if($(this).attr('required') == 'required')
                {
                    $(this).attr('required','required');
                }
            });
            $("#InputVitalicio").parent().parent().show();
            $("#InputMensagemRestricao").parent().parent().show();
            $(".bx-not-free").show();
        }
	});
    if($("#Inputfree").val()==1){
        $("input").each(function(){
            if($(this).attr('required') == 'required')
            {
                $(this).removeAttr('required');
            }
        });
        $("#InputVitalicio").parent().parent().hide();
        $("#InputMensagemRestricao").parent().parent().hide();
        $(".bx-not-free").hide();
    }else{
        $("input").each(function(){
            if($(this).attr('required') == 'required')
            {
                $(this).attr('required','required');
            }
        });
        $("#InputVitalicio").parent().parent().show();
        $("#InputMensagemRestricao").parent().parent().show();
        $(".bx-not-free").show();
	}

	if($("select[name=manual_update_valor]").val()!=1){
		$("#Inputvalor_atual").attr('readonly','readonly');
	}else{
		$("#Inputvalor_atual").removeAttr('readonly');
	}

	$("select[name=manual_update_valor]").change(function(){
		if($("select[name=manual_update_valor]").val()!=1){
			$("#Inputvalor_atual").attr('readonly','readonly');
		}else{
			$("#Inputvalor_atual").removeAttr('readonly');
		}
	});

	$("#Inputcnpj").mask("99.999.999/9999-99");
	$("#Inputcpf").mask("999.999.999-99");
    $(".cnpj").mask("99.999.999/9999-99");
    $(".cpf").mask("999.999.999-99");

	if($("#Inputtipo_pessoa").val()==1){
		$("#Inputcnpj").parent().show();
		$("#Inputcnpj").attr('required','required');

		$("#Inputcpf").val('');
		$("#Inputcpf").removeAttr('required');
		$("#Inputcpf").parent().hide();
	}else{
		$("#Inputcpf").parent().show();
		$("#Inputcpf").attr('required','required');

		$("#Inputcnpj").val('');
		$("#Inputcnpj").removeAttr('required');
		$("#Inputcnpj").parent().hide();
	}

	if($("#Inputcnpj").val() != ''){
		$("#Inputtipo_pessoa").val(1);
	}

	$("#Inputtipo_pessoa").change(function(){
		if($("#Inputtipo_pessoa").val()==1){
			$("#Inputcnpj").parent().show();
			$("#Inputcnpj").attr('required','required');

			$("#Inputcpf").val('');
			$("#Inputcpf").removeAttr('required');
			$("#Inputcpf").parent().hide();
		}else{
			$("#Inputcpf").parent().show();
			$("#Inputcpf").attr('required','required');

			$("#Inputcnpj").val('');
			$("#Inputcnpj").removeAttr('required');
			$("#Inputcnpj").parent().hide();
		}
	});

	$(".telefone").keyup(function () {
		mascara( this, mtel );
	});

	$(".cpf").blur(function(){
		ValidarCPF(this);
	});

	setTimeout(function(){
		$( ".moeda" ).each(function() {
			var valor = floatToMoeda($(this).val()*1);
			$(this).val(valor);
		});
	},500);

	$(".decision").click(function(){
		var link = $(this).attr('href');
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
					window.location.href = link;
				}

			}
		});

		$( ".btnConfirm" ).each(function() {
			var element = this;
			$(document).keypress(function(e) {
				if(e.which == 13) {
					$(element).trigger('click');
				}
			});
		});
		return false;
	});

	$(".password").blur(function(){
		if($(this).val() != ''){
			$("#password-cad").after('<div class="alert alert-danger alert-dismissable confirmation-alert">Redigite sua senha ou então deixe o campo em branco!</div>');
			setTimeout(function(){
				$(".confirmation-alert").fadeOut('fast');
			},3000);
			$("button[name=submit]").hide();
			return false;
		}else{
			$("button[name=submit]").show();
		}
	});

	//Date range picker
	// $('#reservation').daterangepicker();
	// //Date range picker with time picker
	// $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
	// //Date range as a button
	// $('#daterange-btn').daterangepicker(
	// 	{
	// 		ranges: {
	// 			'Today': [moment(), moment()],
	// 			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	// 			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	// 			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	// 			'This Month': [moment().startOf('month'), moment().endOf('month')],
	// 			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	// 		},
	// 		startDate: moment().subtract(29, 'days'),
	// 		endDate: moment()
	// 	},
	// 	function (start, end) {
	// 		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	// 	}
	// );


});

function setToday(input){
	var d = new Date();
	var mounth = Number(d.getMonth())+1;
	$("#"+input).val(d.getFullYear()+"-"+("00" +mounth ).slice(-2)+"-"+("00" + d.getDate()).slice(-2));
}

function resgateDecision(form){
	bootbox.confirm({
		message: "Você deseja realmente resgatar e finalizar todo o aporte?",
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
				$(form).submit();
			}
		}
	});
	return false;
}

function SomenteNumero(e){
	var tecla=(window.event)?event.keyCode:e.which;
	if((tecla>47 && tecla<58)) return true;
	else{
		if (tecla==8 || tecla==0) return true;
		else  return false;
	}
}

function mascara(o,f){
	v_obj=o
	v_fun=f
	setTimeout("execmascara()",1)
}
function execmascara(){
	v_obj.value=v_fun(v_obj.value)
}

function moeda(v){
	v=v.replace(/\D/g,"") // permite digitar apenas numero
	v=v.replace(/(\d{1})(\d{14})$/,"$1.$2") // coloca ponto antes dos ultimos digitos
	v=v.replace(/(\d{1})(\d{11})$/,"$1.$2") // coloca ponto antes dos ultimos 13 digitos
	v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") // coloca ponto antes dos ultimos 10 digitos
	v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos
	v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2") // coloca virgula antes dos ultimos 4 digitos

	return v;
}

function mtel(v){
	v = v.replace(/\D/g, "");
	v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
	v = v.replace(/(\d)(\d{4})$/, "$1-$2");
	return v;
}

function mCNPJ(cnpj){
    cnpj=cnpj.replace(/\D/g,"")
    cnpj=cnpj.replace(/^(\d{2})(\d)/,"$1.$2")
    cnpj=cnpj.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
    cnpj=cnpj.replace(/\.(\d{3})(\d)/,".$1/$2")
    cnpj=cnpj.replace(/(\d{4})(\d)/,"$1-$2")
    return cnpj
}
function mCPF(cpf){
    cpf=cpf.replace(/\D/g,"")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return cpf
}

function moedaToFloat(v){
	if(!isFloat(v) && !isInteger(v)) {
        v = v.replace(".", "");
        v = v.replace(",", ".");
    }

	return v;
}

function isInteger(x) { return typeof x === "number" && isFinite(x) && Math.floor(x) === x; }
function isFloat(n) { return n != "" && !isNaN(n) && Math.round(n) != n;}

function floatToMoeda(valor){
	var inteiro = null, decimal = null, c = null, j = null;
	var aux = new Array();
	valor = ""+valor;
	c = valor.indexOf(".",0);
	//encontrou o ponto na string
	if(c > 0){
		//separa as partes em inteiro e decimal
		inteiro = valor.substring(0,c);
		decimal = valor.substring(c+1,valor.length);

		if(decimal.length === 1) {
			decimal += "0";
		}
	}else{
		inteiro = valor;
	}

	//pega a parte inteiro de 3 em 3 partes
	for (j = inteiro.length, c = 0; j > 0; j-=3, c++){
		aux[c]=inteiro.substring(j-3,j);
	}

	//percorre a string acrescentando os pontos
	inteiro = "";
	for(c = aux.length-1; c >= 0; c--){
		inteiro += aux[c]+'.';
	}
	//retirando o ultimo ponto e finalizando a parte inteiro

	inteiro = inteiro.substring(0,inteiro.length-1);

	decimal = parseInt(decimal);
	if(isNaN(decimal)){
		decimal = "00";
	}else{
		decimal = ""+decimal;
		if(decimal.length === 1){
			decimal = "0"+decimal;
		}
	}
	valor = inteiro+","+decimal;
	return valor;
}

function roundNumber(num, scale) {
	if(!("" + num).includes("e")) {
		return +(Math.round(num + "e+" + scale)  + "e-" + scale);
	} else {
		var arr = ("" + num).split("e");
		var sig = ""
		if(+arr[1] + scale > 0) {
			sig = "+";
		}
		return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
	}
}

function ValidarCPF(Objcpf){
	var cpf = Objcpf.value;

	exp = /\.|\-/g
	cpf = cpf.toString().replace( exp, "" );
	var digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));
	var soma1=0, soma2=0;
	var vlr =11;

	for(i=0;i<9;i++){
		soma1+=eval(cpf.charAt(i)*(vlr-1));
		soma2+=eval(cpf.charAt(i)*vlr);
		vlr--;
	}
	soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));
	soma2=(((soma2+(2*soma1))*10)%11);

	var digitoGerado=(soma1*10)+soma2;
	if(digitoGerado!=digitoDigitado)
		alert('CPF Invalido!');
}

function copyToClipboard(element) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($(element).text()).select();
	document.execCommand("copy");
	$temp.remove();
}


