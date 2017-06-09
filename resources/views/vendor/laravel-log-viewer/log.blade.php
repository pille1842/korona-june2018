@extends('layouts.backend')

@section('title')
    {{ trans('backend.logs') }}
@endsection

@section('stylesheets')
    <style>
        .stack {
            font-size: 0.85em;
        }
        .date {
            min-width: 75px;
        }
        .text {
            word-break: break-all;
        }
        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-3 col-md-3 sidebar">
            <h1><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> {{ trans('backend.logs') }}</h1>
            <div class="list-group">
                @foreach($files as $file)
                    <a href="?l={{ base64_encode($file) }}" class="list-group-item @if ($current_file == $file) llv-active @endif">
                        {{$file}}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-sm-9 col-md-9 table-container">
            @if ($logs === null)
                <div>
                    {{ trans('backend.log_file_bigger_50m') }}
                </div>
            @else
                <table id="table-log" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('backend.loglevel') }}</th>
                            <th>{{ trans('backend.logcontext') }}</th>
                            <th>{{ trans('backend.logdate') }}</th>
                            <th>{{ trans('backend.logcontent') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($logs as $key => $log)
                            <tr data-display="stack{{{$key}}}">
                                <td class="text-{{{$log['level_class']}}}"><span class="glyphicon glyphicon-{{{$log['level_img']}}}-sign" aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
                                <td class="text">{{$log['context']}}</td>
                                <td class="date">{{{\Carbon\Carbon::parse($log['date'])->formatLocalized('%c')}}}</td>
                                <td class="text">
                                    @if ($log['stack'])
                                        <a class="pull-right btn btn-default btn-xs" role="button" data-toggle="collapse" href="#stack{{{$key}}}" aria-expanded="false">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </a>
                                    @endif
                                    {{{$log['text']}}}
                                    @if (isset($log['in_file'])) <br />{{{$log['in_file']}}}@endif
                                    @if ($log['stack']) <div class="collapse stack" id="stack{{{$key}}}" style="white-space: pre-wrap;">{{{ trim($log['stack']) }}}</div>@endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif
            <div>
                @if($current_file)
                    <a href="?dl={{ base64_encode($current_file) }}" class="btn btn-default">
                        <span class="glyphicon glyphicon-download-alt"></span>
                        {{ trans('backend.download_logfile') }}
                    </a>
                    <a id="delete-log" href="?del={{ base64_encode($current_file) }}" class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash"></span>
                        {{ trans('backend.delete_logfile') }}
                    </a>
                    @if(count($files) > 1)
                        <a id="delete-all-log" href="?delall=true" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash"></span>
                            {{ trans('backend.delete_all_logfiles') }}
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
      $(document).ready(function(){
        $('tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });
        $('.table-container').on('click', '.expand', function(){
          $('#' + $(this).data('display')).toggle();
        });
        $('#delete-log, #delete-all-log').click(function(){
          return confirm('Are you sure?');
        });
      });
    </script>
@endsection

@include('components.tool.datatable', ['target' => '#table-log', 'params' => '"order": [ 1, "desc" ],
    "stateSave": true,
    "stateSaveCallback": function (settings, data) {
      window.localStorage.setItem("datatable", JSON.stringify(data));
    },
    "stateLoadCallback": function (settings) {
      var data = JSON.parse(window.localStorage.getItem("datatable"));
      if (data) data.start = 0;
      return data;
    }'])
