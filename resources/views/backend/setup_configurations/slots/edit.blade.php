@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Slot Information')}}</h5>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-0">

                    <form class="p-4" action="{{ route('slots.update', $slot->id) }}" method="POST"
                          enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" placeholder="{{translate('Name')}}"
                                   value="{{ $slot->name }}" name="name" class="form-control"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">{{translate('Value')}}</label>
                            <input type="text" placeholder="{{translate('Value')}}" name="value"
                                   class="form-control" value="{{ $slot->value }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Position')}}</label>
                            <input type="number" placeholder="" name="position"
                                   class="form-control" value="{{ $slot->position }}" required>
                        </div>


                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
