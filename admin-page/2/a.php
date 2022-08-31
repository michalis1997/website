
<!DOCTYPE html>
<html lang="el">
<head>
  <title>Login</title>
  <!-- Setting the viewport to make your website look good on all devices -->
  <meta charset = "utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    
</head>
<body>
  <div class= "container">
    <div class="rows">
      <div class= "col text-center">
        <select class="custom-select" id="content">
          <option value="Application" selected="">Application</option>
          <option value="Text" selected="">Text</option>
          <option value="Image" selected="">Image</option>
          <option value="Html" selected="">Html</option>
          <option value="Video" selected="">Video</option>
          <option value="Font" selected="">Font</option>
          <option value="All"  selected="">All</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col" id="chart2a">
      
      </div>
    </div>
  </div>

  <div style="width: 400px;">
	  <canvas id="chart2a" height="400" width="400"> </canvas>

	</div>

    <!--javascript-->
    
  <script  type="text/javascript" src="C:/wamp64/www/web/website/admin-page/2/package/jquery-3.5.1.min.js"></script>
  <script  type="text/javascript" src="C:/wamp64/www/web/website/admin-page/2/package/dist/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
 
 <script>
    $(document).ready(function(){
    $.ajax({
        url:"a.php",
        type: "POST",
        data:{
            department: "Application"
        }
        success: function(){
            $("#chart2a").html(line_Graph);
			$("#graph").chart = new Chart($("#graph"), $("#graph").data("settings"));
        } 
       

        $("#setDepartment").change(function(){
            $.ajax({
        url:"a.php",
        type: "POST",
        data:{
            department:$().val()
        },
        success: function(){
            $("#chart2a").html(line_Graph);
			$("#graph").chart = new Chart($("#graph"), $("#graph").data("settings"));
        } 
        });
    });
});
</script>

</body>
</html>
 
