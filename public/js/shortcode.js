(()=>{"use strict";$((function(){$.fn.serializeObject=function(){var e={},t=this.serializeArray();return $.each(t,(function(){e[this.name]?(e[this.name].push||(e[this.name]=[e[this.name]]),e[this.name].push(this.value||"")):e[this.name]=this.value||""})),e};var e=$("#shortcode-list-modal"),t=$("#shortcode-modal");function o(e){a({href:e.attr("href"),key:e.data("key"),name:e.data("name"),description:e.data("description")})}function a(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},o=e.href,a=e.key,d=e.name,r=(e.description,e.data),i=void 0===r?{}:r,c=e.update,n=void 0!==c&&c,s=e.previewImage,l=void 0===s?null:s;$(".shortcode-admin-config").html("");var h=$('.shortcode-modal button[data-bb-toggle="shortcode-add-single"]');h.text(h.data(n?"update-text":"add-text")),$(".shortcode-modal .modal-title").text(d),null!=l&&""!==l?$(".shortcode-modal .shortcode-preview-image-link").attr("href",l).show():$(".shortcode-modal .shortcode-preview-image-link").hide(),$(".shortcode-modal").modal("show");var m=t.find(".modal-content");Tec.showLoading(m),$httpClient.make().post(o,i).then((function(e){var t=e.data;$(".shortcode-data-form").trigger("reset"),$(".shortcode-input-key").val(a),$(".shortcode-admin-config").html(t.data),Tec.hideLoading(m),Tec.initResources(),Tec.initMediaIntegrate(),Tec.initFieldCollapse(),document.dispatchEvent(new CustomEvent("core-shortcode-config-loaded"))}))}$('[data-bb-toggle="shortcode-item-radio"]').on("change",(function(){$('[data-bb-toggle="shortcode-use"]').prop("disabled",!1).removeClass("disabled")})),$('[data-bb-toggle="shortcode-add-single"]').on("click",(function(e){e.preventDefault();var t=$(".shortcode-modal").find(".shortcode-data-form"),o=t.serializeObject(),a="";$.each(o,(function(e,o){var d=t.find('*[name="'+e+'"]'),r=d.data("shortcode-attribute");r&&"content"===r||!o||(e=e.replace("[]",""),o&&"string"==typeof o&&(o=(o=o.replace(/"([^"]*)"/g,"“$1”")).replace(/"/g,"“")),"content"!==d.data("shortcode-attribute")&&(e=e.replace("[]",""),a+=" "+e+'="'+o+'"'))}));var d="",r=t.find("*[data-shortcode-attribute=content]");null!=r&&null!=r.val()&&""!==r.val()&&(d=r.val());var i=$(this).closest(".shortcode-modal").find(".shortcode-input-key").val(),c=$(".add_shortcode_btn_trigger").data("result"),n="["+i+a+"]"+d+"[/"+i+"]";if(window.EDITOR&&window.EDITOR.CKEDITOR&&$(".editor-ckeditor").length>0)window.EDITOR.CKEDITOR[c].commands.execute("shortcode",n);else if($(".editor-tinymce").length>0)tinymce.get(c).execCommand("mceInsertContent",!1,n);else{var s=new CustomEvent("core-insert-shortcode",{detail:{shortcode:n}});document.dispatchEvent(s)}$(this).closest(".modal").modal("hide")})),$(document).on("click",'[data-bb-toggle="shortcode-list-modal"]',(function(){e.modal("show")})),$('[data-bb-toggle="shortcode-select"]').on("dblclick",(function(e){o($(e.currentTarget))})),$('[data-bb-toggle="shortcode-use"]').on("click",(function(){o(e.find(".shortcode-item-input:checked").closest(".shortcode-item-wrapper")),$('[data-bb-toggle="shortcode-item-radio"]').prop("checked",!1),$('[data-bb-toggle="shortcode-use"]').prop("disabled",!0).addClass("disabled")})),$('[data-bb-toggle="shortcode-button-use"]').on("click",(function(e){o($(e.currentTarget).closest(".shortcode-item-wrapper"))})),t.on("show.bs.modal",(function(){e.modal("hide"),$('[data-bb-toggle="shortcode-item-radio"]').prop("checked",!1),$('[data-bb-toggle="shortcode-use"]').prop("disabled",!0).addClass("disabled")})),$(document).on("ckeditor-bb-shortcode-callback",(function(e){var t=e.detail;a({key:t.shortcode,href:t.options.url,previewImage:""})})),$(document).on("ckeditor-bb-shortcode-edit",(function(e){var t=e.detail,o=t.shortcode,d=t.name,r=$('[data-bb-toggle="shortcode-select"][data-key="'.concat(d,'"]')),i=r.length>0?r.data("description"):"";a({key:d,href:r.data("url"),data:{key:d,code:o},name:r.data("name"),description:i,previewImage:"",update:!0})})),$(".shortcode-list-modal").on("keyup",'input[type="search"]',(function(e){e.preventDefault();var t=$(this).val().toLowerCase();$(".shortcode-item-wrapper").each((function(e,o){var a=$(o),d=a.data("name").toLowerCase(),r=a.data("description").toLowerCase();d.includes(t)||r.includes(t)?a.parent().show():a.parent().hide()})),0===$(".shortcode-item-wrapper:visible").length?$(".shortcode-empty").show():$(".shortcode-empty").hide()})).on("click",'[data-bb-toggle="shortcode-clear-search"]',(function(e){e.preventDefault(),$(this).closest(".shortcode-list-modal").find('input[type="search"]').val("").trigger("keyup").trigger("focus")}))}))})();