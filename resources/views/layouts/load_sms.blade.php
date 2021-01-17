<script>
	$(function(){

		var us='fvidanueva';
		var pss='V1D4nU3V4@2019';
		token=$('input[name=_token]').val();

                    $.ajax({
                        url: 'lista_mensaje_no_enviados',//SmsMailController@lista_mensaje_no_enviados
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'op':0},
                        beforeSend:function(){
                            //return false;
                        },
                        success:function(dt){
                        	$(dt).each(function(){
                            $("#tmp_sms").html(this['sms_mensaje']);
                               var sms=$("#tmp_sms").text().trim();
                               //alert(sms);
                               var sms_id=this['sms_id'];
                               var tipo=this['sms_tipo'];
                               if(tipo==0){
                                 var num=this['destinatario'].substring(1);
                                 envia_sms(us,pss,num,sms,sms_id);
                               }else{
                                var num=this['destinatario'];
                                envia_correo(num,sms,sms_id);
                              }

                        	})
                        }
                    })
		
	})
  
	function envia_sms(us,pss,num,sms,sms_id){
		var url = "https://sms.innobix.com.ec/sapi/sms_sendingp.php"; 
               $.post(url,{user:us,pss:pss,numero:num,mensaje:sms}, function(response) {
            }, 'json')
               .done(function() {
                alert( "second success" );
            })
               .fail(function() {
                actualiza_estado(sms_id);
            })            		
	}

   function actualiza_estado(id){
      token=$('input[name=_token]').val();                      	
      $.ajax({
        url: 'actualiza_estado_sms',
        headers:{'X-CSRF-TOKEN':token},
        type: 'POST',
        dataType: 'json',
        data: {'sms_id':id},
        beforeSend:function(){
        },
        success:function(dt){
                        }
                    })
  }

  function envia_correo(num,sms,sms_id){
    token=$('input[name=_token]').val();                         
         $.ajax({
            url: 'envia_mails',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {'correo':num,'mensaje':sms},
            beforeSend:function(){
                //return false;
            },
            success:function(dt){
                 if(dt==0){
                     actualiza_estado(sms_id,token);
                 }
            }
        })    
  }
</script>
{{csrf_field()}}
<label id="tmp_sms" hidden></label>
