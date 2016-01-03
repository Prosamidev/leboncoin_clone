$(document).ready(function() {

$(document).on("click" ,"#plus", function(){
        $("#formAddRDV").show();
        $("#plus").hide();
        $(".carousel-inner").remove();
});


$('[id^=container]').click(function(){
       var id = $(this).children(".annonce").attr("id");
       
       if(id !== null ){
                $.ajax({
                    url: Routing.generate('leboncoin_show_annonce', {id: id})
                })
                window.location.href = Routing.generate('leboncoin_show_annonce', {id: id});
       }
   });
   
$('[id^=btnDelete]').click(function(){
        var id = $(this).parents(".row").attr("id");
        var url = "";
        alert(id);
                if (window.location.host == "localhost:8888" || window.location.host == "localhost") {
                    var splitURL = window.location.href.split("php");
                    url = splitURL[0] + "php/remove";
                } else {
                    url = "/remove";
                }
                
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "&id=" + id
                });
               
        $('#'+ id).fadeOut('slow');
        
   });

});