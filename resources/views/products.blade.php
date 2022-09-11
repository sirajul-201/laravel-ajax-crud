<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <title>  Laravel AJAX CRUD  </title>
  </head>
  <body>
    <div class="container">
      <div class="row"> 
        <div class="col-md-2"></div>
      <div class="col-md-10">
        <h2 class="my-5 text-center">Laravel AJAX CRUD</h2>
        <a href="" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#addModal"> Add Product</a>
        <input type="text" class="form-control my-2" id="search" name="search" placeholder="Search Product..." />
        <div class="table-data">
          <table class="table table-bordered ProductTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $key => $product)
              <tr>
                <th> {{ $key+1}}</th>
                <td>{{$product->name}}</td>
                <td>{{$product->price}}</td>
                <td>
                  <a href="" class="btn btn-info update_product_form"
                  data-bs-toggle="modal" 
                  data-bs-target="#updateModal"
                  data-id="{{$product->id}}"
                  data-name="{{$product->name}}"
                  data-price="{{$product->price}}"
                  >
                  <i class="las la-edit"></i>
                  </a>
                  <a href="" class="btn btn-danger delete_product"
                    data-id="{{$product->id}}"
                    >
                    <i class="las la-times"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $products->links() !!}
        </div>
      </div>
      </div>
    </div>
    @include('add_modal')
    @include('update_modal')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    </script>
    <script>
      $(document).ready(function(){

        $(document).on('click', '.add_product', function(e){
          e.preventDefault();

          let name = $('#name').val();
          let price = $('#price').val();
        
          $.ajax({
            url: "{{ route('add.product')}}",
            method:'post',
            data:{
              name:name,
              price:price
            },
            success:function(response){
                if(response.status == 'success'){
                  $('#addModal').modal('hide');
                  $('#AddProductForm')[0].reset();
                  $('.ProductTable').load(location.href+' .ProductTable');

                  Command: toastr["success"]("Product Added.")
                            toastr.options = {
                              "closeButton": true,
                              "debug": false,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": false,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }

                }
            },error:function(err){
              let error = err.responseJSON;
              $.each(error.errors, function(index, value){

                $('.errorMsgContainer').append('<span class="text-danger">'+value+'</span> </br>');

              })
            }
          });
        });


      // edit   

      $(document).on('click', '.update_product_form', function(){
        let id = $(this).data('id');
        let name = $(this).data('name');
        let price = $(this).data('price');

        $('#u_id').val(id);
        $('#u_name').val(name);
        $('#u_price').val(price);
      });

      // update 

      $(document).on('click', '.update_product', function(e){
          e.preventDefault();

          let u_id = $('#u_id').val();
          let u_name = $('#u_name').val();
          let u_price = $('#u_price').val();
         
          $.ajax({
            url: "{{ route('update.product')}}",
            method:'post',
            data:{
              u_id:u_id,
              u_name:u_name,
              u_price:u_price
            },
            success:function(response){
                if(response.status == 'success'){
                  $('#updateModal').modal('hide');
                  $('#UpdateProductForm')[0].reset();
                  $('.ProductTable').load(location.href+' .ProductTable');
                }
            },error:function(err){
              let error = err.responseJSON;
              $.each(error.errors, function(index, value){

                $('.errorMsgContainer').append('<span class="text-danger">'+value+'</span> </br>');

              })
            }
          });
        });

        // delete 

      $(document).on('click', '.delete_product', function(e){
          e.preventDefault();

          let product_id = $(this).data('id');
          
          if(confirm('Are you sure to delete product')){

              $.ajax({
                    url: "{{ route('delete.product')}}",
                    method:'post',
                    data:{
                      product_id:product_id,
                    },
                    success:function(response){
                        if(response.status == 'success'){
                        
                          $('.ProductTable').load(location.href+' .ProductTable');

                          Command: toastr["success"]("Product Delated.")
                            toastr.options = {
                              "closeButton": true,
                              "debug": false,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": false,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }
                        }
                    }
            });
          }
          
        });

        // paginate
        $(document).on('click', '.pagination', function(e){
          e.preventDefault();
         // let page = $(this).attr('href').split('page=')[1]
         var storyId = $('a', this).filter("[href]").attr('href');
         let page = storyId.split('page=')[1]
         product(page);

        });

        function product(page){
          $.ajax({
                url: "/pagination/paginate-data?page="+page,
                success:function(response){
                  $('.table-data').html(response);
                }
            });
        }  

        // search
         $(document).on('keyup',function(e){
          e.preventDefault();
          let search_string = $('#search').val();
           
          $.ajax({
            url: "{{ route('search.product')}}",
            method:'GET',
            data:{
              search_string:search_string,
            },
            success:function(response){
              $('.table-data').html(response);

              if(response.status == 'not_found'){
                 $('.table-data').html('<span class="text-danger">'+response.message+'</span>');
              } 
            }
          });

        });

      });
    </script>
    {!! Toastr::message() !!}
  </body>
</html>