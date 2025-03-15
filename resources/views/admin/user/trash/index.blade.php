<div class="card accordion-item mt-5">
    <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-3"
            aria-expanded="true">
            <i class="bx bx-trash me-2"></i>
            Trash
        </button>
    </h2>
    <div id="accordionWithIcon-3" class="accordion-collapse collapse" style="">
        <div class="accordion-body">
            <table class="invoice-list-table table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Deleted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($trash_users as $trash_user)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $trash_user->name }}</td>
                            <td>{{ $trash_user->email }}</td>
                            <td>{{ $trash_user->deleted_at->diffForHumans() }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" data-popper-placement="top-end">
                                            <form method="POST" action="{{ $trash_user->permalink()->restore }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item" data-toggle="tooltip"
                                                    title="Restore">
                                                    Restore
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ $trash_user->permalink()->force_delete }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item" data-toggle="tooltip"
                                                    title="Delete">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
