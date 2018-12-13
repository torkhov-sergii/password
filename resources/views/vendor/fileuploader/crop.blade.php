<div class="b-fileuploader-crop b-fileuploader-crop_{{ $image_type or '' }}">

    @if($img)
        <div id="fileuploader_crop" style="background-image2: url('{{ $img }}')" data-object="{{ $object }}" data-object_id="{{ $object_id }}" data-aspect_ratio="{{ $aspect_ratio }}" data-image_type="{{ $image_type or '' }}" class="ignore">
            <img src="{{ $img }}">
            <div class="fileuploader_crop_container">
            </div>
        </div>
    @else
        <div id="fileuploader_crop" class="m-fileuploader_crop-empty" data-object="{{ $object }}" data-object_id="{{ $object_id }}" data-aspect_ratio="{{ $aspect_ratio }}" data-image_type="{{ $image_type or '' }}">
            <img src="{{ $img }}" style="display: none">
            <div class="fileuploader_crop_container">
            </div>
        </div>
    @endif

    <div aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" id="popup_fileuploader_crop" style="display: none;">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body center" style="text-align: center">
                    <h2 id="myModalLabel" class="modal-title">Select the area in the photo</h2>

                    <div class="alert alert-warning" style="margin-bottom: 20px; margin-top: 20px;">
                        Recommended dimensions of
                        <b>
                            {{ $aspect_ratio }} px
                        </b>
                    </div>

                    <div style="display: inline-block; overflow: hidden; position: relative;">
                        <img id="crop_image" src="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" id="button_crop">Save</button>
                </div>

            </div>
        </div>
    </div>
</div>

