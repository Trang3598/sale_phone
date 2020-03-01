<div class="modal fade" id="ajax-show-image" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="userCrudModal">{{$product->name_phone}}</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($images as $key => $image)
                        <div class="column">
                            <img src="images/{{$image->image}}" style="width:100%" onclick="myFunction(this);">
                        </div>
                    @endforeach
                </div>
                <div class="container">
                    <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
                    <img id="expandedImg" style="width:100%">
                    <div id="imgtext"></div>
                </div>
            </div>
        </div>
    </div>
</div>


