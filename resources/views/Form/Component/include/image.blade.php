<li>
    <div class="col-md-3"></div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">File</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool close-bloc-image">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        <div class="box-body">
            <span class="mailbox-attachment-icon has-img">
                <img src="/{{$value}}" alt="">
                @if(!empty($multiple) and !empty($value))
                    <input type="hidden" value="{{$value}}" name="{{$name}}[]">
                @elseif(empty($multiple) and !empty($value))
                    <input type="hidden" value="{{$value}}" name="{{$name}}">
                @endif
            </span>

            <div class="mailbox-attachment-info">
                <a href="#" class="mailbox-attachment-name">
                    <span class="mailbox-attachment-size">
                       {{\Trafik8787\LaraCrud\Form\UploadFile::formatBytes(File::size($value), 1)}}
                    </span>
                </a>
            </div>
        </div>
    </div>
</li>