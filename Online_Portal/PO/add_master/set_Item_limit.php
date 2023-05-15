<?php 
session_start();
if (!isset($_SESSION['user_type'])) {
    $_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
  }
  else {
  include('..\..\..\dbcon.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>show_data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style type="text/css">
        .ui-autocomplete {
            max-height: 100px;
            max-width: 330px;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #46dffa;
            font-size: 12px;
            font-family: Tahoma;
            }
            * html .ui-autocomplete {
            height: 100px;
            }

.secondaryContainer {

  overflow-y: scroll;
  border-collapse: collapse;
  height:500px;
}

thead
{
    background-color:  #3ba6bc;
}
thead {
  width: 150px;
  white-space: nowrap;
  height: 50px;
  position: sticky;
  top: 0;
    color: white;
    background-color:  #3ba6bc;
}

::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.9);
}
::-webkit-scrollbar-thumb {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.9);
}

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row bg-info text-white text-center"><h4>Set Item MIN/MAX Limit</h4></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Enter Category/Maingrade/Subgrade/Item for search result.</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="catg" id="catg" value="<?php if(isset($_GET['catg'])){echo $_GET['catg']; } ?>" class="form-control mx-2" placeholder="Category">
                                         <input type="text" name="main_grade" id="main_grade" value="<?php if(isset($_GET['main_grade'])){echo $_GET['main_grade']; } ?>" class="form-control mx-2" placeholder="Search Maingrade">
                                         <input type="text" name="sub_grade" id="sub_grade" value="<?php if(isset($_GET['sub_grade'])){echo $_GET['sub_grade']; } ?>" class="form-control mx-2" placeholder="Subgrade">
                                         <input type="text" name="item" id="item" value="<?php if(isset($_GET['item'])){echo $_GET['item']; } ?>" class="form-control mx-2" placeholder="Search Item">
                                         <input type="hidden" name="Search" value="data" />
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-1">
                                <a href="set_Item_limit.php"><button type="button" class="btn btn-secondary">Reset</button></a>
                            </div>
                            <div class="col-md-1" align="right">
                                <?php if(isset($_GET['Search'])) { ?>
                                <button class="btn btn-success save">Save</button>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card p-2 mt-2">
                    <label>Search from resut</label>
                    <input type='text' id='search-box' placeholder='Search anything from results' class="form-control">
                    <div class="secondaryContainer">
                        <form id="saveItem">
                        <table class="table table-bordered"  style='border-collapse:collapse;'>
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Main Grade</th>
                                    <th>Sub Grade</th>
                                    <th>Item</th>
                                    <th>IS_LIMIT</th>
                                    <th>MIN_LIMIT</th>
                                    <th>MAX_LIMIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                                    
                                    if(isset($_GET['Search']))
                                    {
                                        $query = "SELECT a.i_code,a.item , a.min_limit, a.max_limit, a.is_limit, a.s_code, b.sub_grade, a.m_code, c.main_grade,a.c_code,d.category FROM rm_item a   left outer join rm_s_grade b on a.s_code = b.s_code
                                                left outer join rm_m_grade c on a.m_code = c.m_code left outer join rm_category d on a.c_code = d.c_code WHERE a.c_code > 0";

                                        if($_GET['catg'] != "")
                                        {
                                            $catg = $_GET['catg'];
                                            $query .= " and d.category LIKE '%$catg%'";
                                        }
                                        if($_GET['main_grade']  != "")
                                        {
                                            $main_grade = $_GET['main_grade'];
                                            $query .= " and c.main_grade LIKE '%$main_grade%'";
                                        }
                                        if($_GET['sub_grade']  != "")
                                        {
                                            $sub_grade = $_GET['sub_grade'];
                                            $query .= " and b.sub_grade LIKE '%$sub_grade%'";
                                        }
                                        if($_GET['item']  != "")
                                        {
                                            $item = $_GET['item'];
                                            $query .= " and a.item LIKE '%$item%'";
                                        }
                                        $params = array();
                                        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                        $run=sqlsrv_query($con,$query,$params,$options);
                                        $count=sqlsrv_num_rows($run);

                                        if($count > 0)
                                        {
                                            while($row = sqlsrv_fetch_array($run))
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['category']; ?></td>
                                                    <td><?php echo $row['main_grade']; ?></td>
                                                    <td><?php echo $row['sub_grade']; ?></td>
                                                    <td><?php echo  $row['item']; ?>
                                                        <input type="hidden" name="i_code[]" class="form-control" value="<?php echo  $row['i_code']; ?>" readonly/>
                                                    </td>
                                                    <td><input type="text" name="is_limit[]" class="form-control" value="Yes" readonly/></td>
                                                    <td><input type="text" name="min_limit[]" class="form-control" value="<?php echo $row['min_limit']; ?>" /></td>
                                                    <td><input type="text" name="max_limit[]" class="form-control" value="<?php echo $row['max_limit']; ?>" /></td>
                                                </tr>
                                                <?php
                                            }
                                            
                                        }
                                        else
                                        {
                                            ?>
                                                <tr>
                                                    <td colspan="4">No Record Found</td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</body>
</html>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">

    (function () 
    {
        var showResults;
        $('#search-box').keyup(function ()
        {
            var searchText;
            searchText = $('#search-box').val();
            return showResults(searchText);
        });
        showResults = function (searchText) {
            $('tbody tr').hide();
            return $('tbody tr:Contains(' + searchText + ')').show();
        };
        jQuery.expr[':'].Contains = jQuery.expr.createPseudo(function (arg) {
            return function (elem) {
                return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });
    }.call(this));

$(document).ready(function()
{
    //catg
    $( "#catg" ).autocomplete(
    {
        source: function( request, response ) 
        {
            // Fetch data
            $.ajax(
            {
                url: "fetch_item.php?status=0",
                type: 'post',
                dataType: "json",
                data: {catg: request.term},
                success: function( data ) 
                {
                    response( data );
                    console.log(data);
                }
            }); 
        },
        select: function (event, ui) 
        {
              // Set selection
              $('#catg').val(ui.item.label);
                return false;
        },
        change: function (event, ui)  //if not selected from Suggestion
        {
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
        }
    });

    //main_grade
    $( "#main_grade" ).autocomplete(
    {
        source: function( request, response ) 
        {
            // Fetch data
            $.ajax(
            {
                url: "fetch_item.php?status=1",
                type: 'post',
                dataType: "json",
                data: {mgrade: request.term},
                success: function( data ) 
                {
                    response( data );
                    console.log(data);
                }
            }); 
        },
        select: function (event, ui) 
        {
              // Set selection
              $('#main_grade').val(ui.item.label);
                return false;
        },
        change: function (event, ui)  //if not selected from Suggestion
        {
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
        }
    });

    //sub_grade
    $( "#sub_grade" ).autocomplete(
    {
        source: function( request, response ) 
        {
            // Fetch data
            $.ajax(
            {
                url: "fetch_item.php?status=2",
                type: 'post',
                dataType: "json",
                data: {sgrade: request.term},
                success: function( data ) 
                {
                    response( data );
                    console.log(data);
                }
            }); 
        },
        select: function (event, ui) 
        {
              // Set selection
              $('#sub_grade').val(ui.item.label);
                return false;
        },
        change: function (event, ui)  //if not selected from Suggestion
        {
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
        }
    });

    //item
    $( "#item" ).autocomplete(
    {
        source: function( request, response ) 
        {
            // Fetch data
            $.ajax(
            {
                url: "fetch_item.php?status=3",
                type: 'post',
                dataType: "json",
                data: {item: request.term},
                success: function( data ) 
                {
                    response( data );
                    console.log(data);
                }
            }); 
        },
        select: function (event, ui) 
        {
              // Set selection
              $('#item').val(ui.item.label);
                return false;
        },
        change: function (event, ui)  //if not selected from Suggestion
        {
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
        }
    });
    //  $('.content-edit').attr('contenteditable', 'true');
    // // Setup - add a text input to each footer cell
    
    // $('#tableaa thead th').each(function () 
    // {
    //     var title = $(this).text();
    //     $(this).html('<input type="text" placeholder="' + title + '" />');
    // });
 
    // // DataTable
    // var table = $('#tableaa').DataTable
    // ({
    //     ordering:false,
    //     columnDefs: [
    //         { "type": "html-input", "targets": [0,1,2,3,4,5,6] }
    //     ] ,
    //     initComplete: function () 
    //     {
    //         // Apply the search
    //         this.api()
    //         .columns()
    //         .every(function () {
    //             var that = this;

    //             $('input', this.header()).on('keyup change clear', function () {
    //                 if (that.search() !== this.value) {
    //                     that.search(this.value).draw();
    //                 }
    //             });
    //         });
    //     },
    // });
  });

$(document).on('click','.save',function()
{

    $.ajax(
    {
        url:"set_Item_limit_db.php?status=0",
        type:"POST",
        data:$('#saveItem').serialize(),
        success:function(data)
        {
            alert(data);
            window.location.href = "set_Item_limit.php";
        }
    }); 
    
});

</script>

<?php } ?>