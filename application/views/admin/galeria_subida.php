<script>
function delete_file_svc(link,filename)
{
$('#file_multiple_select option[value='+filename+']').remove();
$(link).parent().remove();
    $.post(<?=base_url()?> + 'admin/gestores/delete_file', 'file_name='+filename, function(json){
        if(json.succes == 'true')
        {
            console.log('json data', json);
        }
    }, 'json');   
}
$(document).ready(function() {
    $('#multi_aploade_field').fileupload({
         url: <?=base_url()?>+'admin/gestores',
         sequentialUploads: true,
         cache: false,
          autoUpload: true,
          dataType: 'json',
          acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
          limitMultiFileUploads: 1,
          beforeSend: function()
          {
			  $('#upload-button-svc').slideUp('fast');
			  $('#ajax-loader-file').css('display','block');
			  $('#progress-multiple').css('display','block');
          },
          progress: function (e, data) {
        $('#progress-multiple').html(string_progress + parseInt(data.loaded / data.total * 100, 10) + '%');
        },
          done: function (e, data)
          {
           console.log(data.result);
           $('#file_multiple_select').append('<option value='+data.result.file_name+' selected=\"selected\">'+data.result.file_name+'</select>');
           var is_image = (data.result.file_name.substr(-4) == '.jpg'  
                                        || data.result.file_name.substr(-4) == '.png' 
                                        || data.result.file_name.substr(-5) == '.jpeg' 
                                        || data.result.file_name.substr(-4) == '.gif' 
                                        || data.result.file_name.substr(-5) == '.tiff')
                                                ? true : false;
         var html;
         if(is_image==true)
         {
         html='<div id='+data.result.file_name+' ><a href="'+ <?=base_url()?>+ 'uploads/anuncios' +data.result.file_name+' class="image-thumbnail" id="fancy_'+data.result.file_name+'">';
         html+='<img src="'+ <?=base_url()?>+ 'uploads/anuncios' +data.result.file_name+'" height="50"/>';
         html+='</a><a href="javascript:" onclick="delete_file_svc(this,'+data.result.file_name+')" style="color:red;" >Delete</a><div>';
        $('#file_list_svc').append(html);
$('.image-thumbnail').fancybox({
        'transitionIn'	:	'elastic',
        'transitionOut'	:	'elastic',
        'speedIn'		:	600, 
        'speedOut'		:	200, 
        'overlayShow'	:	true
});
         }
         else
         {
          html = '<div id="'+data.result.file_name+'" ><span>'+data.result.file_name+'</span> <a href="javascript:" onclick="delete_file_svc(this,'+data.result.file_name+')" style="color:red;" >Delete</a><div>';
         $('#file_list_svc').append(html);
}
          $('#upload-button-svc').show('fast');
          $('#ajax-loader-file').css('display','none');
          $('#progress-multiple').css('display','none');
          $('#progress-multiple').html('');
          }
     });
 
});
</script>
<div>
	<span class="fileinput-button qq-upload-button" id="upload-button-svc">
		<span>Subir una Foto</span>
		<input type="file" name="multi_aploade" id="multi_aploade_field" >
	</span> <span class="qq-upload-spinner" id="ajax-loader-file" style="display:none;"></span>
	<span id="progress-multiple" style="display:none;"></span>
</div>
<select name="files[]" multiple="multiple" size="8" class="multiselect" id="file_multiple_select" style="display:none;"></select>
<div id="file_list_svc" style="margin-top: 40px;"></div>
<?=$foto?>