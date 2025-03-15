<a href="{{ route('export.database') }}" class="btn btn-primary btn-xs py-0 mb-3">Export</a>
@if (count($backups))
{!! generate_table($backups->toArray()['data'], [
    'attributes' => ['class' => 'table'],
    'column' => ['id', 'backup_path', 'created_at'],
    'action' => 'admin.button.backup_db',
]) !!}
@else 
<p class="text-center fw-bold">No backup generated yet.</p>
@endif