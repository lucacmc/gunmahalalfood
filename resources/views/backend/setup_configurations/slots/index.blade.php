@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="h3">{{translate('All Shipping Slots')}}</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <form class="" id="sort_slots" action="" method="GET">
                    <div class="card-header row gutters-5">
                        <div class="col text-center text-md-left">
                            <h5 class="mb-md-0 h6">{{ translate('Shipping Slot') }}</h5>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="sort_slot" name="sort_slot"
                                   @isset($sort_slot) value="{{ $sort_slot }}"
                                   @endisset placeholder="{{ translate('Type slot name & Enter') }}">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit">{{ translate('Filter') }}</button>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                        <tr>
                            <th data-breakpoints="lg">#</th>
                            <th>{{translate('SlotName')}}</th>
                            <th>{{translate('Slot value')}}</th>
                            <th>{{translate('Position')}}</th>
                            <th>{{translate('Show/Hide')}}</th>
                            <th data-breakpoints="lg" class="text-right">{{translate('Options')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($slots as $key => $slot)
                            <tr>
                                <td>{{ ($key+1) + ($slots->currentPage() - 1)*$slots->perPage() }}</td>
                                <td>{{ $slot->name }}</td>
                                <td>{{ $slot->value }}</td>
                                <td>{{ $slot->position }}</td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_status(this)" value="{{ $slot->id }}"
                                               type="checkbox" <?php if ($slot->status == 1) echo "checked";?> >
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                       href="{{ route('slots.edit', ['id'=>$slot->id, 'lang'=>env('DEFAULT_LANGUAGE')]) }}"
                                       title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                       data-href="{{route('slots.destroy', $slot->id)}}"
                                       title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $slots->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add New Slot') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('slots.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Slot Name')}}</label>
                            <input type="text" placeholder="{{translate('Slot Name')}}" name="name" class="form-control"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">{{translate('Slot Value')}}</label>
                            <input type="text" placeholder="{{translate('Slot Value')}}" name="value"
                                   class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Position')}}</label>
                            <input type="number" placeholder="" name="value"
                                   class="form-control" required>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function sort_slots(el) {
            $('#sort_slots').submit();
        }

        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('slots.status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Data has updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

    </script>
@endsection
