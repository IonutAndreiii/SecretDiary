<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">

$(".toggleform").click(function(){

    $("#signupform").toggle();
    $("#loginform").toggle(); 

});

 $('#diary').bind('input propertychange', function(){
 
    $.ajax({

        method: "POST",
         url: "updatedatabase.php", 
        data: { content: $("#diary").val()  }

     })
 });
</script>
</body>
</html>