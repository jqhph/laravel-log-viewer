<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laravel log viewer</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            padding: 25px;
            background: #eff3f8;
            color: #414750;
            font-size: 14px;
        }
        ol, ul {
            margin-top: 0;
            margin-bottom: 10px;
        }

        h3 {
            font-weight: 400;
            font-size: 18px;
            margin-bottom: 0;
        }

        .logo {
            padding-left: 15px;
            font-weight: 400;
            font-size: 25px;
        }

        .box {
            background: #fff;
            box-shadow: 0 2px 3px #cdd8df;
        }

        .box-header, .box-footer {
            padding: 15px;
        }
        .box-footer {
            border-top: 1px solid #efefef;
        }

        .box-title a {
            color: #414750
        }

        .table th {
            background-color: #f4f7fa;
            font-weight: 400;
            padding: .5rem 1.25rem;
            border-bottom: 0;
        }

        .table td, .table th {
            border-color: #efefef;
        }

        .table>thead>tr>th {
            border-bottom: 1px solid #e3e7eb!important;
        }
        .table-hover tbody tr:hover {
            background-color: #f4f8fb
        }

        .label {
            max-width: 100%;
            margin-bottom: 5px;
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }

        a {
            color: #586cb1
        }
        a:hover, a:focus {
            color: #4b5ea0
        }

        .bg-danger {
            color: #fff;
            background-color: #ef5753!important;
        }
        .bg-primary {
            color: #fff;
            background-color: #586cb1!important;
        }
        .bg-black {
            color: #fff;
            background-color: #444;
        }
        .bg-light {
            color: #555;
            background-color: #d2d6de!important;
        }
        .bg-orange {
            color: #fff;
            background-color: #dda451;
        }
        .bg-light-blue {
            color: #fff;
            background-color: #59a9f8;
        }
        .bg-maroon {
            color: #fff;
            background-color: #c00;
        }
        .bg-navy {
            color: #fff;
            background-color: #6f42c1;
        }

        .btn-default {
            color: #414750;
        }

        a.btn-default {
            background-color: #efefef;
        }

        .btn-primary {
            background-color: #586cb1;
            border-color: #586cb1;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary.active {
            background-color: #4b5ea0;
            border-color: #4b5ea0;
        }

        .btn-danger {
            background-color: #ef5753;
            border-color: #ef5753;
        }

        pre {
            padding: 7px;
            white-space: pre-wrap;
            margin-bottom: 0;
            word-break: break-all;
            /*background-color: #f7f7f9;*/
            display: block;
            font-size: 90%;
            color: #2a2e30;
        }
        strong {
            color: #7c858e;
        }
        .trace-dump {
            white-space: pre-wrap;
            background: #222;
            color: #fff;
            padding: 1.5rem;
        }

        .nav {
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }
        .nav>li {
            position: relative;
            display: block;
        }
        .nav-pills>li {
            float: left;
        }
        .nav-stacked>li {
            float: none;
            width: 100%;
        }
        .nav>li>a {
            position: relative;
            display: block;
            padding: 6px 15px;
        }
        .nav-pills>li>a {
            border-radius: 4px;
        }
        .nav-pills>li>a {
            border-radius: 0;
            border-top: 3px solid transparent;
            color: #444;
        }
        .nav-stacked>li>a {
            border-radius: 0;
            border-top: 0;
            border-left: 3px solid transparent;
            color: #444;
        }
        .nav-pills>li>a>.fa, .nav-pills>li>a>.glyphicon, .nav-pills>li>a>.ion {
            margin-right: 5px;
        }
        .nav-stacked>li.active>a, .nav-stacked>li.active>a:hover {
            background: transparent;
            color: #4b5ea0;
            border-top: 0;
            font-weight: 600;
            /*border-left-color: #586cb1;*/
        }

        .nav>li>a.dir {
            font-size: 1rem;
        }

    </style>
</head>
<body>

<div class="wrapper pl-2 pr-2">

    <div class="row">

        <div class="col-md-2">
            <div class="logo">
                Dcat Log Viewer
            </div>

            <div class="">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-folder-open-o"></i>
                        <a href="{{ route('dcat-log-viewer') }}">logs</a>
                        @if($dir)
                            @php($tmp = '')
                            @foreach(explode('/', $dir) as $v)
                                @php($tmp .= '/'.$v)
                                /
                                <a href="{{ route('dcat-log-viewer', ['dir' => trim($tmp, '/')])}}">{{ $v }}</a>
                            @endforeach
                        @endif
                    </h3>
                </div>

                <form action="{{ route('dcat-log-viewer') }}" style="display: inline-block;width: 220px;padding-left: 15px">
                    <div class="input-group-sm" style="display: inline-block;width: 100%">
                        <input name="filename" class="form-control" value="{{ app('request')->get('filename') }}" type="text" placeholder="Search..." />
                    </div>
                </form>

                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        @if(! app('request')->get('filename'))
                            @foreach($logDirs as $d)
                                <li @if($d === $fileName) class="active" @endif>
                                    <a class="dir" href="{{ route('dcat-log-viewer', ['dir' => $d]) }}">
                                        <i class="fa fa-folder-o"></i>{{ basename($d) }}
                                    </a>
                                </li>
                            @endforeach
                        @endif

                        @foreach($logFiles as $log)
                            <li @if($log['active'])class="active"@endif>
                                <a href="{{ $log['url'] }}">
                                    <i class="fa fa-file-text{{ ($log['active']) ? '' : '-o' }}"></i>{{ $log['file'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a href="{{ route('dcat-log-viewer.download', ['dir' => $dir, 'file' => $fileName, 'filename' => app('request')->get('filename')]) }}" class="btn btn-primary btn-sm download" style="color: #fff"><i class="fa-download fa"></i> {{ trans('Download') }}</a>

{{--                    <button class="btn btn-default btn-sm download"><i class="fa-trash-o fa"></i> {{ trans('Delete') }}</button>--}}
                    &nbsp;
                    <form action="{{ app('request')->fullUrlWithQuery(['keyword' => null,]) }}" style="display: inline-block;width: 180px">
                        <div class="input-group-sm" style="display: inline-block;width: 100%">
                            <input type="hidden" name="dir" value="{{ $dir }}">
                            <input type="hidden" name="filename" value="{{ app('request')->get('filename') }}">
                            <input name="keyword" class="form-control" value="{{ app('request')->get('keyword') }}" type="text" placeholder="Search..." />
                        </div>
                    </form>
                    <div class="float-right">
                        <a class=""><strong>Size:</strong> {{ $size }} &nbsp; <strong>Updated at:</strong>
                        {{ date('Y-m-d H:i:s', filectime($filePath)) }}</a>
                        &nbsp;
                        <div class="btn-group">
                            @if ($prevUrl)
                                <a href="{{ $prevUrl }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Previous</a>
                            @endif
                            @if ($nextUrl)
                                <a href="{{ $nextUrl }}" class="btn btn-default btn-sm">Next <i class="fa fa-chevron-right"></i></a>
                            @endif
                        </div>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">

                    <div class="table-responsive">
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th></th>
                                <th>Level</th>
                                <th>Env</th>
                                <th>Time</th>
                                <th>Message</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($logs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="label bg-{{\Dcat\LogViewer\LogViewer::$levelColors[$log['level']]}}">{{ $log['level'] }}</span></td>
                                    <td><strong>{{ $log['env'] }}</strong></td>
                                    <td style="width:150px;">{{ $log['time'] }}</td>
                                    <td><pre>{{ $log['info'] }}</pre></td>
                                    <td>
                                        @if(!empty($log['trace']))
                                            <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target=".trace-{{$index}}"><i class="fa fa-info"></i>&nbsp;&nbsp;Exception</button>
                                        @endif
                                    </td>
                                </tr>

                                @if (!empty($log['trace']))
                                    <tr class="collapse trace-{{$index}}">
                                        <td colspan="6"><div class="trace-dump">{{ $log['trace'] }}</div></td>
                                    </tr>
                                @endif

                            @endforeach

                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>


                </div>
                <div class="box-footer">
                    <div class="float-left">
                        <a class=""><strong>Size:</strong> {{ $size }} &nbsp; <strong>Updated at:</strong>
                            {{ \Carbon\Carbon::create(date('Y-m-d H:i:s', filectime($filePath)))->diffForHumans() }}</a>
                    </div>
                    <div class="float-right">
                        <div class="btn-group">
                            @if ($prevUrl)
                                <a href="{{ $prevUrl }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Previous</a>
                            @endif
                            @if ($nextUrl)
                                <a href="{{ $nextUrl }}" class="btn btn-default btn-sm">Next <i class="fa fa-chevron-right"></i></a>
                            @endif
                        </div>
                        <!-- /.btn-group -->
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- /. box -->
        </div>

    </div>
</div>


<!-- jQuery for Bootstrap -->
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
