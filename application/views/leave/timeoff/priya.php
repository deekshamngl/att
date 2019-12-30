
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Datatable</title>
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
   <div class="container mt-5">
       <table id="userTable" class="table">
           <thead>
               <th>Employee name</th>
               <th>Designation</th>
               <th>Departement</th>
           </thead>
           <tbody>
               <?php if(!empty($arr_users)) { ?>
                   <?php foreach($arr_users as $user) { ?>
                       <tr>
                           <td><?php echo $user['employeename']; ?></td>
                           <td><?php echo $user['designation']; ?></td>
                           <td><?php echo $user['departement']; ?></td> 
                       </tr>
                   <?php } ?>
               <?php } ?>
           </tbody>
       </table>
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
   <script>
       $(document).ready(function() {
           $('#userTable').DataTable();
       } );
   </script>
</body>
</html>
