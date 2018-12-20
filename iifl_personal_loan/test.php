<!doctype html>
<html>
<head>
  <title>DHTML + AJAX test</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $('input[name=cityname]').keyup(function() {
        if($(this).val().length >= 3) {
         /* $.ajax({
            //url: '/get_temp_ajax',
            dataType: 'json',
            data : {
              'city': $(this).val(),
            },
            success:function(data) {
              data= {"status": "success", "data": [{"Kolkata": "31"}, {"Kolhapur": "26"}]};
              console.log(data);
            }
          
          });*/
          response = {"status": "success", "data": [{"Kolkata": "31"}]};
          console.log(response.data[0])
          if(response.status == 'success' && response.data.length == 1) {

          }

        }
        
      });
    });
  </script>
</head>
<body>
  <h1>Temperature in your City</h1>
  <p>
    The temperature in <span id="city">Unknown</span> 
       is <span id="temperature">Unknown</span> degrees celcius.
  </p>
  <form id="form1" 
        action="http://example.com/get_temp/"
        method="POST">
      City: <input type="text" name="cityname">
      <input type="submit" value="Update">
  </form>
</body>
</html>