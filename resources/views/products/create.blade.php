@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Створити товар</h1>
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
                <form id="create" method="post" action="{{ route('products.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Назва продукта:</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>

                    <div class="form-group" id="upload-group">
                        <img class="chose-image" src="{{ asset('images/200_default.png') }}"
                                id="chooseImage" alt="Обрати фото">
                        <input type="hidden" name="base64Image" id="base64Image">

                        <input type="file" id="selectImage" class="d-none">
                    </div>

                    <div class="form-group">
                        <label for="email">Опис:</label>
                        <textarea class="form-control" name="description" id ="edit" rows="10" cols="45" ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add contact</button>
                </form>
            </div>
        </div>
    </div>

    <!--Stack Photo  -->
    <div class="stackPhoto">
        <div class="wrapper">
            <header>
                <h1>Stock photo</h1>
                <span>ID: 5988014</span>
            </header>

            <div class="ways">
                <ul>
                    <li class="active">
                        submit
                    </li>
                    <li>
                        discussion
                    </li>
                </ul>
            </div>

            <div class="sections">

                <section class="active">
                    <input type="text" placeholder="Title" id="title"/>
                    <select id="category">
                        <option value="summmer">summer</option>
                        <option value="winter">winter</option>
                        <option value="working">working</option>
                        <option value="road">road</option>
                    </select>

                    <div class="select-option">
                        <div class="head">Category</div>
                        <div class="option"></div>
                    </div>


                    <div class="images">
                        <div class="pic">
                            add
                        </div>
                    </div>


                </section>

                <section>
                    <input type="text" placeholder="Topic" id="topic"/>
                    <textarea placeholder="something..." id="msg"></textarea>
                </section>

            </div>

            <footer>
                <ul>
                    <li><span id="reset">reset</span></li>
                    <li><span id="send">send</span></li>
                </ul>
            </footer>

        </div>
        <div class="notification"></div>
        <footer>
            Inspiration: <a href="https://dribbble.com/shots/2092775-Create-a-new-collection"><i class="fa fa-dribbble" aria-hidden="true"></i>dribbble</a>
        </footer>
    </div>


    <!-- Modal -->
    <div class="modal" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <img id="imageCropper" src="{{ asset('images/200_default.png') }}" height="400">
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="img-rotation" class="btn btn-success"><i class="fa fa-repeat" aria-hidden="true"></i></a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="cropImg" class="btn btn-primary">Обрізати фото</button>
                </div>
            </div>
        </div>
    </div>
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
                $selectImage.click();
            });

            //коли обрали файл
            $selectImage.on("change", function() {
                if (this.files && this.files.length) {
                    let file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        dialogCropper.modal('show');
                        cropper.replace(e.target.result);

                    }
                    reader.readAsDataURL(file);

                }
            });

            //запуск кропера
            const imageCropper = document.getElementById('imageCropper');
            const cropper = new Cropper(imageCropper, {
                aspectRatio: 1/1,
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
            $("#img-rotation").on("click",function (e) {
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

    <script>
        //запускаємо фороалу едітор
        $(function () {
            const editorInstance = new FroalaEditor('#edit', {
                enter: FroalaEditor.ENTER_P,
                placeholderText: null,
                events: {
                    initialized: function () {
                        const editor = this;
                        this.el.closest('form').addEventListener('submit', function (e) {
                            // cosnole.log("--------", editor);
                            // e.preventDefault();
                        })
                    }
                }
            })
        });
    </script>


    <script>
        (function ($) {
            $(document).ready(function () {

                generateID()
                choose()
                generateOption()
                selectionOption()
                removeClass()
                uploadImage()
                submit()
                resetButton()
                removeNotification()
                autoRemoveNotification()
                autoDequeue()

                var ID
                var way = 0
                var queue = []
                var fullStock = 10
                var speedCloseNoti = 1000

                function generateID() {
                    var text = $('header span')
                    var newID = ''

                    for(var i = 0; i < 3; i++) {
                        newID += Math.floor(Math.random() * 3)
                    }

                    ID = 'ID: 5988' + newID
                    text.html(ID)
                }

                function choose() {
                    var li = $('.ways li')
                    var section = $('.sections section')
                    var index = 0
                    li.on('click', function () {
                        index = $(this).index()
                        $(this).addClass('active')
                        $(this).siblings().removeClass('active')

                        section.siblings().removeClass('active')
                        section.eq(index).addClass('active')
                        if(!way) {
                            way = 1
                        }  else {
                            way = 0
                        }
                    })
                }

                function generateOption() {
                    var select = $('select option')
                    var selectAdd = $('.select-option .option')
                    $.each(select, function (i, val) {
                        $('.select-option .option').append('<div rel="'+ $(val).val() +'">'+ $(val).html() +'</div>')
                    })
                }

                function selectionOption() {
                    var select = $('.select-option .head')
                    var option = $('.select-option .option div')

                    select.on('click', function (event) {
                        event.stopPropagation()
                        $('.select-option').addClass('active')
                    })

                    option.on('click', function () {
                        var value = $(this).attr('rel')
                        $('.select-option').removeClass('active')
                        select.html(value)

                        $('select#category').val(value)
                    })
                }

                function removeClass() {
                    $('body').on('click', function () {
                        $('.select-option').removeClass('active')
                    })
                }

                function uploadImage() {
                    var button = $('.images .pic')
                    var uploader = $('<input type="file" accept="image/*" />')
                    var images = $('.images')

                    button.on('click', function () {
                        uploader.click()
                    })

                    uploader.on('change', function () {
                        var reader = new FileReader()
                        reader.onload = function(event) {
                            images.prepend('<div class="img" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +'"><span>remove</span></div>')
                        }
                        reader.readAsDataURL(uploader[0].files[0])

                    })

                    images.on('click', '.img', function () {
                        $(this).remove()
                    })

                }

                function submit() {
                    var button = $('#send')

                    button.on('click', function () {
                        if(!way) {
                            var title = $('#title')
                            var cate  = $('#category')
                            var images = $('.images .img')
                            var imageArr = []


                            for(var i = 0; i < images.length; i++) {
                                imageArr.push({url: $(images[i]).attr('rel')})
                            }

                            var newStock = {
                                title: title.val(),
                                category: cate.val(),
                                images: imageArr,
                                type: 1
                            }

                            saveToQueue(newStock)
                        } else {
                            // discussion
                            var topic = $('#topic')
                            var message = $('#msg')

                            var newStock = {
                                title: topic.val(),
                                message: message.val(),
                                type: 2
                            }

                            saveToQueue(newStock)
                        }
                    })
                }

                function removeNotification() {
                    var close = $('.notification')
                    close.on('click', 'span', function () {
                        var parent = $(this).parent()
                        parent.fadeOut(300)
                        setTimeout(function() {
                            parent.remove()
                        }, 300)
                    })
                }

                function autoRemoveNotification() {
                    setInterval(function() {
                        var notification = $('.notification')
                        var notiPage = $(notification).children('.btn')
                        var noti = $(notiPage[0])

                        setTimeout(function () {
                            setTimeout(function () {
                                noti.remove()
                            }, speedCloseNoti)
                            noti.fadeOut(speedCloseNoti)
                        }, speedCloseNoti)
                    }, speedCloseNoti)
                }

                function autoDequeue() {
                    var notification = $('.notification')
                    var text

                    setInterval(function () {

                        if(queue.length > 0) {
                            if(queue[0].type == 2) {
                                text = ' Your discusstion is sent'
                            } else {
                                text = ' Your order is allowed.'
                            }

                            notification.append('<div class="success btn"><p><strong>Success:</strong>'+ text +'</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
                            queue.splice(0, 1)

                        }
                    }, 10000)
                }

                function resetButton() {
                    var resetbtn = $('#reset')
                    resetbtn.on('click', function () {
                        reset()
                    })
                }

                // helpers
                function saveToQueue(stock) {
                    var notification = $('.notification')
                    var check = 0

                    if(queue.length <= fullStock) {
                        if(stock.type == 2) {
                            if(!stock.title || !stock.message) {
                                check = 1
                            }
                        } else {
                            if(!stock.title || !stock.category || stock.images == 0) {
                                check = 1
                            }
                        }

                        if(check) {
                            notification.append('<div class="error btn"><p><strong>Error:</strong> Please fill in the form.</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
                        } else {
                            notification.append('<div class="success btn"><p><strong>Success:</strong> '+ ID +' is submitted.</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
                            queue.push(stock)
                            reset()
                        }
                    } else {
                        notification.append('<div class="error btn"><p><strong>Error:</strong> Please waiting a queue.</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
                    }
                }
                function reset() {

                    $('#title').val('')
                    $('.select-option .head').html('Category')
                    $('select#category').val('')

                    var images = $('.images .img')
                    for(var i = 0; i < images.length; i++) {
                        $(images)[i].remove()
                    }

                    var topic = $('#topic').val('')
                    var message = $('#msg').val('')
                }
            })
        })(jQuery)
    </script>
@endsection
