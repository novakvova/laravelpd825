
@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-1">
            <h1 class="display-3">{{$user->name}}</h1>
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
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row my-2">
            <div class="col-lg-8 order-lg-2">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Change info</a>
                    </li>
                </ul>
                <div class="tab-content py-4">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3"><span class="badge badge-dark badge-pill">Name:</span> {{$user->name}}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><span class="badge badge-dark badge-pill">Email:</span> {{$user->email}}</h6>
                                <h6><span class="badge badge-dark badge-pill">Date of birth:</span> 01/01/1990</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Нещодавні покупкт тварин</h6>
                                <a href="#" class="badge badge-dark badge-pill">Крокодил</a>
                                <a href="#" class="badge badge-dark badge-pill">Видра</a>
                                <a href="#" class="badge badge-dark badge-pill">Тарантул</a>
                                <a href="#" class="badge badge-dark badge-pill">Черепаха</a>
                                <a href="#" class="badge badge-dark badge-pill">Бобер</a>
                                <a href="#" class="badge badge-dark badge-pill">Кіт-товстун</a>
                                <hr>
                                <span class="badge badge-primary"><i class="fa fa-user"></i> 63 Покупки</span>
                                <span class="badge badge-success"><i class="fa fa-cog"></i> 43 Корм</span>
                                <span class="badge badge-danger"><i class="fa fa-eye"></i> 20 Тварини</span>
                            </div>
                    </div>
                    </div>

                    <div class="tab-pane" id="edit">
                        <form method="post" action="/profile/change">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Name</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="email" name="email" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Password</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" name="password" value="{{$user->password}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" value="{{$user->password}}">
                                </div>
                            </div>
                            <div class="col-lg-4 order-lg-1 text-center">
                                <img class="chose-image" src="/images/840_{{$user->image}}"
                                     id="chooseImage" alt="Обрати фото">
                                <input type="hidden" name="base64Image" id="base64Image">
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <input type="reset" class="btn btn-secondary" value="Cancel">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    @include('view._croper-modal');
@endsection

@section('scripts')
    <script>
        jQuery(function () {
            //фото по якому клікаємо і обираємо файл
            $chooseImage = $("#chooseImage");

            //текстове поле із base64
            $base64Image = $("#base64Image");

            //скритий інпут для вибору файла
            $selectImage = $("#selectImage");


            let dialogCropper = $("#cropperModal");

            //клікнули по фото і клікаємо по скритому інпуту файл
            $chooseImage.on("click", function () {
                let uploader = $('<input type="file" accept="image/*" />');
                uploader.click()
                uploader.on('change', function () {
                    if (this.files && this.files.length) {
                        let file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            dialogCropper.modal('show');
                            cropper.replace(e.target.result);

                        }
                        reader.readAsDataURL(file);

                    }

                });
            });

            //запуск кропера
            const imageCropper = document.getElementById('imageCropper');
            const cropper = new Cropper(imageCropper, {
                aspectRatio: 1 / 1,
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

            //поворот малюнка
            $("#img-rotation").on("click", function (e) {
                e.preventDefault();
                cropper.rotate(45);
            });

            //обрізка малюнка
            $("#cropImg").on("click", function (e) {
                e.preventDefault();

                var imgContent = cropper.getCroppedCanvas().toDataURL();
                $chooseImage.attr("src", imgContent);
                dialogCropper.modal('hide');
                $base64Image.val(imgContent);
            });


        })
    </script>
@endsection
