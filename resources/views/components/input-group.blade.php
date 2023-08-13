<div class="{{$grid}}">
    <div class="form-group">
        <label for="{{$name}}" class="{{$labelclass}}">{{$labelname}}</label>
        <input type="{{$type}}" id="{{$id}}" name="{{$name}}" placeholder="{{$placeholder}}" class="{{$class}}"
               {{$step!=null ? 'step="'.$step.'"':""}} {{$min!=null ? 'min="'.$min.'"':""}}
               @isset($value) value="{{$value}}" @endisset
               @isset($disabled) disabled="{{$disabled}}" @endisset
               @isset($required) required="{{$required}}" @endisset
               @isset($read) readonly="{{$read}}" @endisset />

    </div>
</div>
