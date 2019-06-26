@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/dropzone.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css"/>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @can('upload content', App\User::class)
        <div class="col-md-8">
            <form class="form-horizontal" action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file" id="file">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div><br>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info pull-right">Save</button>
                </div>
                <!-- /.box-footer -->
              </form>
        </div>
        @endcan
        @can('view content', App\User::class)
        <div class="col-md-8"><br>
            <table class="table table-sm">
                <tbody id="data">
                </tbody>
            </table>  
        </div>
        @endcan
    </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('js/dropzone.js') }}"></script>
  <script type="text/javascript">
      $(document).ready(function() {
        loadData();
       });

       function loadData(){
        axios.get('files')
        .then(function (response) {
            if (response.data.alert==='success') {
                $('#data').html(response.data.res)
            } else if (response.data.alert==='empty') {
                console.log('empty');
                
            }
        })
        .catch(function (error) {
            console.log(error);
        });
       }

        $(document).on('click', 'a.downLink', function() {
            var file_name = $(this).closest('tr').find('td:nth-child(1)').text();
            downloadFile(file_name)
        })

       function downloadFile(file_name){
        axios.post('save-download-info', {
          fileName: file_name,
        })
        .then(function (response) {
            console.log(response);
            
            if (response.data.alert==='success') {
                window.location.href = 'download/'+file_name
            } else {
                console.log(response.data.msg);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
       }
  </script>
  {{-- <script type="text/javascript">
    Dropzone.options.adImageUpload = {
      url: 'files.store',
      addRemoveLinks: true,
      parallelUploads:5,
      maxFiles:5,
      accept: function(file) {
          let fileReader = new FileReader();

          fileReader.readAsDataURL(file);
          fileReader.onloadend = function() {

              let content = fileReader.result;
              $('#file').val(content);
              file.previewElement.classList.add("dz-success");
          }
          file.previewElement.classList.add("dz-complete");
      }
    }
  </script> --}}

  @if(\Session::has('success'))
    <script type="text/javascript">
      alertify.success('Data Saved !', 'success', 10, function(){  console.log('success'); });
    </script>
  @endif

  @endsection
