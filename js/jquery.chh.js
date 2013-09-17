/*
 *
 * shsing建立的jquery 插件
 *
 */

(function($) {



	get_url = function (){
		url = location.href.lastIndexOf("?") == -1 ? location.href.substring((location.href.lastIndexOf("/")) + 1) : location.href.substring((location.href.lastIndexOf("/")) + 1, location.href.lastIndexOf("?"));
		return url;
	}

	/* 處理ajax回傳參數及後續動作 */
	process_ajax_return = function(obj){
		if(obj.error == 1){
			jAlert(obj.message, SYS_MSG, function(r){
												if(obj.field){
													$("[name='"+obj.field+"']").focus();
												}
												if(obj.url){
													location.href = obj.url;
												}
											});
		}else{
//			if(obj.url){
//				if(obj.message){
//					jAlert(obj.message, SYS_MSG, function(){location.href = obj.url;});
//				}else{
//					location.href = obj.url;
//				}
//			}

			/*重新整理頁面*/
			if(obj.reload_all){
				if(obj.message){
					jAlert( obj.message,
							SYS_MSG,
							function(r){
								window.top.document.location.reload();
							}
					);
				}
			/* 當有上傳圖時*/
			}else if(obj.upload){
				switch(obj.upload){
					/* 相簿上傳圖 */
					case 'img':

						var tol = 0;
						var msg = '';
						$('input[name="img"]').each(function(i, val){
							if(val.value != '' ){
								tol++;
							}
						});

						$('input[name="img"]').each(function(i, val){
							if(val.value != '' ){
								$.ajaxFileUpload
								(
									{
										url:get_url(),
										secureuri:false,
										fileDataName: 'img',
										fileElement:val,
										dataType: 'json',
										scriptData : {act:'upload_img', id:obj.id, op:obj.op},
										success: function (data, status)
										{
											if(data.error == 1){
												msg += val.value+'  '+data.message+'\r\n';
											}
											tol--;
											if(tol == 0){
												if(msg == ''){
													msg = obj.message;
												}

												jAlert( msg,
														SYS_MSG,
														function(r){
															if(	obj.url){
																location.href = obj.url;
															}
														}
												);
											}
										},
										error: function (data, status, e)
										{
											alert(e);
										}
									}
								)
								/*
								$.ajaxFileUpload
								(
									{
										url:get_url(),
										secureuri:false,
										fileDataName: 'img',
										fileElement:val,
										dataType: 'json',
										scriptData : {act:'upload_img', id:obj.id, op:obj.op},
										success: function (data, status)
										{
											if(data.error == 1){
												msg += val.value+'  '+data.message+'\r\n';
											}
											tol--;
											if(tol == 0){
												if(msg == ''){
													msg = obj.message;
												}

												jAlert( msg,
														SYS_MSG,
														function(r){
															if(	obj.url){
																location.href = obj.url;
															}
														}
												);
											}
										},
										error: function (data, status, e)
										{
											alert(e);
										}
									}
								)
								*/
							}
						});

						var tmp_name = $('input[name$="_img"]').attr('name');

						$('input[name$="_img"]').each(function(i, val){
							if(val.value != '' ){
								tol++;
							}
						});

						$('input[name$="_img"]').each(function(i, val){
							if(val.value != '' ){
								img_brief = $('input[name="img_brief"]')[i].value;
								img_sort = $('input[name="img_sort"]')[i].value;
								$.ajaxFileUpload
								(
									{
										url:get_url(),
										secureuri:false,
										fileDataName: tmp_name,
										fileElement:val,
										dataType: 'json',
										scriptData : {act:'upload_'+tmp_name, id:obj.id, op:obj.op, img_brief:img_brief, img_sort:img_sort},
										success: function (data, status)
										{
											if(data.error == 1){
												msg += val.value+'  '+data.message+'\r\n';
											}
											tol--;
											if(tol == 0){
												if(msg == ''){
													msg = obj.message;
												}

												jAlert( msg,
														SYS_MSG,
														function(r){
															if(	obj.url){
																location.href = obj.url;
															}
														}
												);
											}
										},
										error: function (data, status, e)
										{
											alert(e);
										}
									}
								)
							}
						});

						if(tol == 0){
							if(msg == ''){
								msg = obj.message;
							}

							jAlert( msg,
									SYS_MSG,
									function(r){
										if(	obj.url){
											location.href = obj.url;
										}
									}
							);
						}

						break;
					/* 系統設置上傳圖 */
					case 'config_img':

						var tol = 0;
						var msg = '';
						$('input[type="file"]').each(function(i, val){
							if(val.value != '' ){
								tol++;
							}
						});

						$('input[type="file"]').each(function(i, val){
							if(val.value != '' ){
								$.ajaxFileUpload
								(
									{
										url:get_url(),
										secureuri:false,
										fileDataName: 'img',
										fileElement:val,
										dataType: 'json',
										scriptData : {act:'upload_file', id:val.name},
										success: function (data, status)
										{
											if(data.error == 1){
												msg += val.value+'  '+data.message+'\r\n';
											}
											tol--;
											if(tol == 0){
												if(msg == ''){
													msg = obj.message;
												}

												jAlert( msg,
														SYS_MSG,
														function(r){
															if(	obj.url){
																location.href = obj.url;
															}
														}
												);
											}

										},
										error: function (data, status, e)
										{
											alert(e);
										}
									}
								)
							}
						});

						if(tol == 0){
							if(msg == ''){
								msg = obj.message;
							}

							jAlert( msg,
									SYS_MSG,
									function(r){
										if(	obj.url){
											location.href = obj.url;
										}
									}
							);
						}

						break;
					/* 檔案下載 - 上傳 */
					case 'download_file':

						var tol = 0;
						var msg = '';

						$('input[name="download_file"]').each(function(i, val){
							if(val.value != '' ){
								tol++;
							}
						});
						$('input[name="download_file"]').each(function(i, val){
							if(val.value != '' ){
								file_brief = $('input[name="file_brief"]')[i].value;
								file_sort = $('input[name="file_sort"]')[i].value;
								$.ajaxFileUpload
								(
									{
										url:get_url(),
										secureuri:false,
										fileDataName: 'download_file',
										fileElement:val,
										dataType: 'json',
										scriptData : {act:'upload_download_file', id:obj.id, op:obj.op, file_brief:file_brief, file_sort:file_sort},
										success: function (data, status)
										{
											if(data.error == 1){
												msg += val.value+'  '+data.message+'\r\n';
											}
											tol--;
											if(tol == 0){
												if(msg == ''){
													msg = obj.message;
												}

												jAlert( msg,
														SYS_MSG,
														function(r){
															if(	obj.url){
																location.href = obj.url;
															}
														}
												);
											}
										},
										error: function (data, status, e)
										{
											alert(e);
										}
									}
								)
							}
						});

						if(tol == 0){
							if(msg == ''){
								msg = obj.message;
							}

							jAlert( msg,
									SYS_MSG,
									function(r){
										if(	obj.url){
											location.href = obj.url;
										}
									}
							);
						}

						break;
					default:
						break;
				}

			}else if(obj.message){
				jAlert( obj.message,
					   	SYS_MSG,
						function(r){
							if(obj.url){
								location.href = obj.url;
							}
						}
				);
			}else if(obj.url){
				location.href = obj.url;
			}else if(obj.content){
				try{
					$('#listDiv').html( obj.content );

					if (typeof obj.filter == "object")
					{
						if(typeof listTable != 'undefined'){
							listTable.filter = obj.filter;
						}
					}

					jHide();
				}catch(e){
					jAlert(e, SYS_MSG);
				}
			}
		}
	}

	/* 設定ajax預設值*/
	$.ajaxSetup({
		url: get_url(),
		type: "POST",
		dataType: "json",
		beforeSend:function(){ jProcess(PROCESS, SYS_MSG);},
		success: process_ajax_return
	});

	jQuery.extend({
	    handleError: function( s, xhr, status, e ) {
	        // If a local callback was specified, fire it
	        if ( s.error )
	            s.error( xhr, status, e );
	        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
	        else if(xhr.responseText)
	            console.log(xhr.responseText);
	    }
	});


	/* 實作ajax動作 */
	do_ajax = function(o){

//		/* 處理html編輯器內容 */
//		$("iframe[id$='Frame']").prev().prev().each(function(i, val){
//			val.value = FCKeditorAPI.GetInstance(val.name).GetXHTML();
//		});

		/* 處理html編輯器內容 */
		$("span[id^='cke_'][class^='cke_skin_office2003']").prev().each(function(i, val){
			val.value = CKEDITOR.instances[val.name].getData();
		});

		var frm = Object;
		$("form").each(function(i, val){
			if(o == val){
				frm = $("form:eq("+(i)+")")
			}
		});

		var url = frm.attr("action");
		url = url==''?get_url():url;
		var data = frm.serialize();
		data += '&is_ajax=1';

		$.ajax({
		   	url: url,
		   	data: data
		});

		return false;
	}

	/* 移除某筆資料 */
	var tid=0;
	remove = function(id){
		tid=id;
		jConfirm(DROP_CONFIRM, SYS_MSG, do_reault);
	}
	do_reault = function(t, id){

		if(t){
			var data = {
			   act: "remove",
			   id: tid
			};

			$.ajax({
				data: data
			});
		}
	}



	/**
	 * 折疊分類列表
	 */
 	var imgPlus = new Image();
	imgPlus.src = "images/menu_plus.gif";
	rowClicked = function (obj)
	{
		obj = obj.parentNode.parentNode;

		var tbl = document.getElementById("list-table");
		var lvl = parseInt(obj.className);
		var fnd = false;

		for (i = 0; i < tbl.rows.length; i++){
			var row = tbl.rows[i];

			if (tbl.rows[i] == obj){
				fnd = true;
			}else{
				if (fnd == true){
					var cur = parseInt(row.className);
					if (cur > lvl){
						row.style.display = (row.style.display != 'none') ? 'none' : ($.browser.msie) ? 'block' : 'table-row';
					}else{
						fnd = false;
						break;
					}
				}
			}
		}

		for (i = 0; i < obj.cells[0].childNodes.length; i++){
			var imgObj = obj.cells[0].childNodes[i];
			if (imgObj.tagName == "IMG" && imgObj.src != 'images/menu_arrow.gif')
		 	{
			 	imgObj.src = (imgObj.src == imgPlus.src) ? 'images/menu_minus.gif' : imgPlus.src;
			}
		}
	}

	/* 無限分類當選根分類時只可選底下 */
	check_location_from = function(){
		var location_from = $("select[name='location_from']")[0];
		if(location_from.value == 1){
			$("input[name='location_type']")[0].checked = true;
			$("input[name='location_type']")[1].disabled = true;
			$("input[name='location_type']")[2].disabled = true;
		}else{
			$("input[name='location_type']")[1].disabled = false;
			$("input[name='location_type']")[2].disabled = false;
		}
	}

	/* 清除緩存*/
	clear_cache = function(){
		var data = {
			act: "clear_cache"
		};
		$.ajax({
		   	url: 'index.php',
		   	data: data
		});
	}

	/* 前台換頁 */
	ajax_page = function (to_page){

		var data = {
			act: "query",
			page:to_page
		};

		$.ajax({
		   	data: data
		});
	}

	add_to_cart = function(obj){

		var data = {
			act: "add_to_cart",
			id:obj.id
		};

		$.ajax({
			url:'cart.php',
		   	data: data
		});
	}

	CKEDITOR_reset = function(){
		/* 處理html編輯器內容 */
		$("span[id^='cke_'][class^='cke_skin_office2003']").prev().each(function(i, val){
			CKEDITOR.instances[val.name].setData('');
		});
	}
})(jQuery);