function SEOPressor_external_cloaked($){if(!SEOPressor_external_cloaked_triggered){SEOPressor_external_cloaked_triggered=true;$(".seopressor-grid-add-button").button({icons:{primary:"ui-icon-plus"}}).click(function(){$("#seopressor-cloaked-redirect-grid").jqGrid("editGridRow","new",{addCaption:"Add Cloaked Redirect",addedrow:"last",afterSubmit:function(response,postdata){var data=$.parseJSON(response.responseText);if(data.type=="notification"){return[true,data.message];}else{if(data.type=="error"){return[false,data.message];}}},bSubmit:"Add",closeAfterAdd:true,closeOnEscape:true,dataheight:180,editData:{object:"external_cloacked_links",id:"",action:"seopressor_add"},modal:false,mtype:"POST",recreateForm:true,url:ajaxurl,width:400});});$("body").on("click",".action_edit",function(){var selected_row=$("#seopressor-cloaked-redirect-grid").jqGrid("getGridParam","selrow");if(selected_row!=null){$("#seopressor-cloaked-redirect-grid").jqGrid("editGridRow",selected_row,{afterSubmit:function(response,postdata){var data=$.parseJSON(response.responseText);if(data.type=="notification"){return[true,data.message];}else{if(data.type=="error"){return[false,data.message];}}},bSubmit:"Done",checkOnSubmit:true,closeAfterEdit:true,closeOnEscape:true,dataheight:180,editCaption:"Edit Cloaked Redirect",editData:{object:"external_cloacked_links",action:"seopressor_add"},modal:true,mtype:"POST",recreateForm:true,url:ajaxurl,width:400});}else{$("#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container").remove();$('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first a <strong>Cloacked Redirect</strong>.</p></div>').appendTo("body");$("#seopressor-thickbox-dialog-link").trigger("click");$("#TB_window").css({height:"auto",left:"60%",top:"35%",width:"20%"});$("#TB_ajaxContent").css({width:"90%"});$("#TB_ajaxContent p").css({"text-align":"center"});}});$("body").on("click",".action_delete",function(){var selected_row=$("#seopressor-cloaked-redirect-grid").jqGrid("getGridParam","selrow");if(selected_row!=null){$("#seopressor-cloaked-redirect-grid").jqGrid("delGridRow",selected_row,{addCaption:"Delete Cloaked Redirect",afterSubmit:function(response,postdata){var data=$.parseJSON(response.responseText);if(data.type=="notification"){return[true,data.message];}else{if(data.type=="error"){return[false,data.message];}}},bSubmit:"Delete",modal:false,mtype:"POST",delData:{object:"external_cloacked_links",action:"seopressor_del"},url:ajaxurl});}else{$("#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container").remove();$('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first a <strong>Cloacked Redirect</strong>.</p></div>').appendTo("body");$("#seopressor-thickbox-dialog-link").trigger("click");$("#TB_window").css({height:"auto",left:"60%",top:"35%",width:"20%"});$("#TB_ajaxContent").css({width:"90%"});$("#TB_ajaxContent p").css({"text-align":"center"});}});var seopressor_cloaked_redirect_grid=$("#seopressor-cloaked-redirect-grid").jqGrid({altRows:false,autowidth:true,caption:"",colModel:[{align:"center",classes:"actions_column",index:"actions",name:"actions",search:false,sortable:false,width:18},{align:"left",classes:"keywords_column",editable:true,editrules:{required:true},edittype:"text",firstsortorder:"asc",formoptions:{elmsuffix:" (*) <br />&nbsp;<em>Separated comma values.</em>"},index:"keywords",name:"keywords",search:true,sortable:true,stype:"text",width:40},{align:"left",classes:"cloaking_folder_column",editable:true,editrules:{required:true},edittype:"text",formoptions:{elmsuffix:" (*) <br />&nbsp;<em>Example: <strong>recommends</strong>.</em>"},index:"cloaking_folder",name:"cloaking_folder",search:true,sortable:true,stype:"text",width:40},{align:"left",classes:"external_url_column",editable:true,editrules:{required:true},edittype:"text",firstsortorder:"asc",formoptions:{elmsuffix:" (*)"},index:"external_url",name:"external_url",search:true,sortable:true,stype:"text",width:40},{align:"right",classes:"times_to_link_column",editable:true,editrules:{required:true},editoptions:{defaultValue:2},edittype:"text",firstsortorder:"asc",formoptions:{elmsuffix:'&nbsp;<span title="If your keyword appears more than 1 time, how many times should it be cloacked?" class="seopressor-icon-info"></span>'},index:"times_to_link",name:"times_to_link",search:true,sortable:true,stype:"text",width:40}],colNames:["","<strong>Keywords</strong>","<strong>Cloaking Folder</strong>","<strong>External URL</strong>","<strong>How many times to link</strong>"],datatype:"json",deselectAfterSort:false,emptyrecords:"No <strong>Cloaked Redirects</strong> found!",forceFit:true,gridview:true,height:"auto",hoverrows:true,ignoreCase:true,loadui:"block",mtype:"POST",pager:"#seopressor-cloaked-redirect-grid-pager",postData:{object:"external_cloacked_links",action:"seopressor_list"},prmNames:{sort:"orderby",order:"orderdir"},rowList:[10,20,30],rowNum:10,rownumbers:true,sortname:"keywords",url:ajaxurl,viewrecords:true}).jqGrid("navGrid","#seopressor-cloaked-redirect-grid-pager",{edit:false,edittext:"<strong>Edit</strong>",add:false,addtext:"<strong>Add</strong>",del:false,deltext:"<strong>Delete</strong>",search:false,refresh:false,refreshtext:"<strong>Refresh</strong>",view:false,closeOnEscape:true,refreshstate:"current"},{afterSubmit:function(response,postdata){var data=$.parseJSON(response.responseText);if(data.type=="notification"){return[true,data.message];}else{if(data.type=="error"){return[false,data.message];}}},bSubmit:"Done",checkOnSubmit:true,closeAfterEdit:true,closeOnEscape:true,dataheight:180,editCaption:"Edit Cloaked Redirect",editData:{object:"external_cloacked_links",action:"seopressor_add"},modal:true,mtype:"POST",recreateForm:true,url:ajaxurl,width:400},{addCaption:"Add Cloaked Redirect",addedrow:"last",afterSubmit:function(response,postdata){var data=$.parseJSON(response.responseText);if(data.type=="notification"){return[true,data.message];}else{if(data.type=="error"){return[false,data.message];}}},bSubmit:"Add",closeAfterAdd:true,closeOnEscape:true,dataheight:180,editData:{object:"external_cloacked_links",id:"",action:"seopressor_add"},modal:false,mtype:"POST",recreateForm:true,url:ajaxurl,width:400},{addCaption:"Delete Cloaked Redirect",afterSubmit:function(response,postdata){var data=$.parseJSON(response.responseText);if(data.type=="notification"){return[true,data.message];}else{if(data.type=="error"){return[false,data.message];}}},bSubmit:"Delete",modal:false,mtype:"POST",delData:{object:"external_cloacked_links",action:"seopressor_del"},url:ajaxurl},{},{},{});$("#seopressor-cloaked-redirect-grid").jqGrid("filterToolbar",{searchOnEnter:false});}}seop_jquery(SEOPressor_external_cloaked);SEOPressor_external_cloaked_triggered=false;function OnErrorResponse(){if(document.readyState==="interactive"&&!SEOPressor_external_cloaked_triggered){SEOPressor_external_cloaked(seop_jquery);}}if(window.addEventListener){window.addEventListener("error",OnErrorResponse);}else{window.attachEvent("onerror",OnErrorResponse);}