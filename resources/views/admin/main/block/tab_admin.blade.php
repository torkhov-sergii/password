@permission('type')
<div role="admin" class="tab-pane" id="admin">
    <div class="form-group" style="display2: flex">
        <label for="name" class="control-label">Parent id - для перемещения в дереве (for root: 1)</label>
        <input type="text" name="parent_id" value="{{ $main->parent_id }}" class="form-control" style="width: 100px;">
    </div>

    <div class="form-group" style="display2: flex">
        <label for="name" class="control-label">Type id - смена типа</label>
        <input type="text" name="type_id" value="{{ $main->type_id }}" class="form-control" style="width: 100px;">
    </div>
</div>
@endpermission