@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List User</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Full name" name="full_name"
                                        id="full_name">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" name="email"
                                        id="email">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button class="btn btn-primary" id="search">Search</button>
                            </div>
                        </div>
                    </div>
                    <table id="table" class="demo-add-niftycheck" data-toggle="table"
                            data-url="{{ route('user.ajax-data') }}"
                            data-toolbar=""
                            data-query-params="queryParams"
                            data-sort-name="id"
                            data-page-list="[5, 10, 20]"
                            data-page-size="5"
                            data-pagination="true" data-side-pagination="server">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="email" data-sortable="true">Email</th>
                            <th data-field="full_name" data-sortable="true">full name</th>
                            <th data-field="phone" data-sortable="true">Phone</th>
                            <th data-field="id" data-align="center" data-formatter="operationFormatter">Delete</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('_js')

    <script type="text/javascript">
		function queryParams(params) {

			var email = $('#email').val()
            if (email !== '') {
				params.email = email
			}

			var fullName = $('#full_name').val()
            if (fullName !== '') {
				params.full_name = fullName
			}

			return params
		}
		$(document).ready(function () {

			$('#search').on('click', function (e) {
				$('#table').bootstrapTable('refresh')
			})

		})

		function operationFormatter(value, row, index, field) {
			var btnDelete = [
					'<a href="{{ url('user/remove') }}/' + row['id'] + '" title="delete" class="btn btn-danger btn-icon btn-xs"><i class="ion-trash"></i></a> '
				].join('');
            return [btnDelete].join('');
		}
    </script>
@endsection
