
@if (!empty($obj->value))
    <div class="form-group">
        <div class="col-md-1">

        </div>
        <div class="col-md-9">
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">File</h3>
                    <div class="box-tools pull-right">
                        <a type="button" class="btn btn-box-tool" data-toggle="collapse" href="#collapseOne">
                            <i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="box-body" id="collapseOne">

                    <ul class="mailbox-attachments clearfix">

                        <li>
                            <span class="mailbox-attachment-icon has-img">
                                <img src="/{{$obj->value}}" alt="">
                            </span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                                <span class="mailbox-attachment-size">
                                    1.9 MB
                                    <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                </span>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

@endif

<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <input type="file" multiple name="{{$obj->name}}" title="{{$obj->title}}" value="{!! $obj->value !!}"
               class="form-control {{$obj->classStyle}}" id="{{$obj->name}}" placeholder="{{$obj->placeholder}}">
    </div>
</div>