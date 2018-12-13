@if($item->files)
    @foreach($item->files as $file)
        <div class="body__pdf">
            @if($file->file_content_type == 'application/pdf' && $item->bool2 == 1)
                <div class="js__pdf-container">
                    <div class="js__pdf-content">

                    </div>

                    <div class="js_pdf-source" style="display: none">
                        <object data="{{ $file->getUrl() }}" type="application/pdf" width="100%" height="100%" style="height: 600px;">
                            <embed src="{{ $file->getUrl() }}" type="application/pdf">
                            <p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="{{ $file->getUrl() }}">Download PDF</a>.</p>
                        </object>
                    </div>
                </div>
            @endif
        </div>

        <div class="body__file">
            <a class="button" href="{{ $file->getUrl() }}" target="_blank">
                <i class="fas fa-download"></i> {{ trans('messages.button.download') }}
            </a>
        </div>
    @endforeach
@endif