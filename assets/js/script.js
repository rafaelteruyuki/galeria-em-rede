jQuery(document).ready(function($) {
	//logica para o menu mobile
	$("#menu-abre").on('click', function(event) {
		event.preventDefault();
		$("html").addClass('menu-ativo');
	});

	$("#menu-fecha").on('click', function(event) {
		event.preventDefault();
		$("html").removeClass('menu-ativo');
	});
	
	document.documentElement.onclick = function(event) {
		if (event.target === document.documentElement) {
			document.documentElement.classList.remove('menu-ativo');
		}
	};
	
	
	//configuracao do eventos para os selects de area e subarea
	$("#area").on('change', function(){
		
		if($(this).val() == ""){
			$("#subarea").find("option:nth-child(n+2)").remove();
		}else{
			preencheSubarea($(this).val());
		}
		
		consultaPorArea($(this).val());
	});
	
	$("#subarea").on('change', function(){
		var area = $("#area").val();
		var subarea = $(this).val();
		
		if($(this)){
			consultaPorSubarea(area, subarea);
		}else{
			consultaPorArea($("#area").val());
		}
	});
	
	
	//funcao que atualiza a tela com a consulta retornada
	function atualizaTelaComExpo(exposicoes){
		var mainTag = $("#exposicoes");
		mainTag.empty();
		
		for(expo in exposicoes){
			var figcaption = $("<figcaption>").text(exposicoes[expo]["title"]);
			
			var divImg = $("<div class='imagem'>");
			
			var img = $("<img>").attr({
				'src' : exposicoes[expo]["imgSrc"],
				'alt' : exposicoes[expo]["imgAlt"]
			});
			
			img.appendTo(divImg);

			var a = $("<a>").attr('href', exposicoes[expo]["permalink"]).append(divImg, figcaption);
			var figure = $("<figure>").append(a);

			mainTag.append(figure);
		};
	}
	
	//abre requisicao AJAX para consultar as subareas da área escolhida
	function preencheSubarea(area){
		var dados = {
			'action' : 'consultar_subarea',
			'area' : area
		};
		
		$.post(ajax_object.ajax_url, dados, function(resposta) {
            var options = $.parseJSON(resposta);
			console.log(options);
			var selectSubarea = $("#subarea");
			
			if(options != null){
				selectSubarea.find("option:nth-child(n+2)").remove();
							
				$.each(options, function(value, label){
					var option = $("<option>");
					option.val(value);
					option.text(label);
					option.appendTo(selectSubarea);
				});
			}else{
				selectSubarea.attr('disabled', true);
			}
		});
	}
	
	// dispara AJAX para consultar as expos da AREA escolhida
	function consultaPorArea(area){
		var dados = {
			'action' : 'consultar_por_area',
			'area' : area
		}
		
//		$.ajax({
//			data: dados,
//			type: "POST",
//			url: ajax_object.ajax_url,
//			timeout: 20000,
//			contentType: 'text/html; charset=ISO-8859-15',
//			dataType: 'json',
//			success: function(resposta){
//				var exposicoes = $.parseJSON(resposta);
//				atualizaTelaComExpo(exposicoes);
//			}
//		});
		
		$.post(ajax_object.ajax_url, dados, function(resposta){
			var exposicoes = $.parseJSON(resposta);
			atualizaTelaComExpo(exposicoes);
		});
	}
	
	// dispara AJAX para consultar as expos da SUBAREA escolhida
	function consultaPorSubarea(area, subarea){
		var dados = {
			'action' 	   : 'consultar_por_subarea',
			'subareaKey'   : 'subarea-' + area,
			'subareaValue' : subarea
		}
		
		$.post(ajax_object.ajax_url, dados, function(resposta){
			var exposicoes = $.parseJSON(resposta);
			atualizaTelaComExpo(exposicoes);
		});
	}
	
	
	// carrega opções do lightbox
	lightbox.option({
		'albumLabel': 'Imagem %1 de %2',
		'wrapAround': true
	});
	
});