<!DOCTYPE html>
<html>
<head>
<title>logged in users</title>
<meta charset="UTF-8">
</head>
<body>
<table style="width:50%">
  <tr>
    <th>First Name</th>
    <th>Last Name</th> 
  </tr>
  <?php foreach ($data as $value) { ?>
  <tr>
    <td><?php echo $value['first_name'];?></td>
    <td><?php echo $value['last_name'];?></td> 
  </tr>
  
  <?php }?>
  
</table>

</body>
</html>