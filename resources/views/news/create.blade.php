@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Створити новину</h1>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form id="create" method="post" action="{{ route('news.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Заголовок новини</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>

                    <img class="mb-3" id="ph" src="/images/200_default.png">
                    <input type="hidden" name="image" id="image">
                    <div class="form-group">
                        <label for="email">Опис:</label>
                        <textarea class="form-control" name="description" id ="description" rows="10" cols="45" ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add news</button>
                </form>
            </div>
        </div>
    </div>

    @include("view._croper-modal")

@endsection

@section('scripts')

    <script>
        (function ($) {
            $(document).ready(function () {

                //загрузка фото на клік
                uploadImage();

                //загрузка фото на клік
                function uploadImage() {
                    let cropper = null;
                    let button = $('.images .pic');
                    let dialogCropper = $("#cropperModal");

                    let images = $('.images');

                    $("#ph").on('click', function () {
                        if (cropper == null) {
                            const imageCropper = document.getElementById('imageCropper');
                            cropper = new Cropper(imageCropper, {
                                aspectRatio: 224 / 168,
                                viewMode: 1,
                                autoCropArea: 0.5,
                                crop(event) {
                                    // console.log(event.detail.x);
                                    // console.log(event.detail.y);
                                    // console.log(event.detail.width);
                                    // console.log(event.detail.height);
                                    // console.log(event.detail.rotate);
                                    // console.log(event.detail.scaleX);
                                    // console.log(event.detail.scaleY);
                                },
                            });

                            //обрізка малюнка
                            $("#cropImg").on("click", function (e) {
                                e.preventDefault();
                                var imgContent = cropper.getCroppedCanvas().toDataURL();
                                $("#ph").attr("src",imgContent);
                                $("#image").attr("value",imgContent)

                                dialogCropper.modal('hide');
                            });
                        }


                        let uploader = $('<input type="file" accept="image/*" />');
                        uploader.click()
                        uploader.on('change', function () {
                            let reader = new FileReader();
                            reader.onload = function (event) {

                                dialogCropper.modal('show');
                                cropper.replace(event.target.result);
                                uploader.remove();
                                //
                            };
                            reader.readAsDataURL(uploader[0].files[0]);

                        });
                    });

                    images.on('click', '.img', function () {
                        $(this).remove();
                    });
                }
            });
        })(jQuery);
    </script>


    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('node_modules/tinymce-i18n/langs/uk.js') }}"></script>

    <script>
        tinymce.init({
            selector: 'textarea#description',
            language: "uk",
            theme: "silver",
            menubar: true,
            skin: 'oxide-dark',
            content_css: 'dark',
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste code help wordcount",
            ],
            toolbar:
                "undo redo | formatselect | bold italic backcolor | \
     alignleft aligncenter alignright alignjustify | \
     bullist numlist outdent indent | removeformat | help",
        });
        // $(function () {
        //     new FroalaEditor('#edit');
        // });
    </script>


@endsection
