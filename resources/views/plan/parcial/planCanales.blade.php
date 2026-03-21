<div class="row">
    @foreach ($canales as $canal)
    <div class="col-md-4 col-sm-6">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="ch_[]" value="{{ $canal->ID_CAN }}" {{ in_array($canal->ID_CAN, $asignados, true) ? 'checked' : '' }}>
                {{ $canal->NOM_CAN }}
            </label>
        </div>
    </div>
    @endforeach
</div>
