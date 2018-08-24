@extends('frame.adminframe')
@section('title','用户及权限管理')
@section('subtitleUrl',route('adminShowUsersList'))
@section('adminDrawerActiveVal','drawer-userItem')

@section('content')

    <h3 class="admin-title mdui-text-color-indigo">编辑角色
        <button type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-pink-accent mdui-float-right"><i class="mdui-icon material-icons mdui-icon-left">edit</i>确认编辑</button>
    </h3>
    @include('admin.layout.msg')
    <div class="mdui-typo-caption mdui-text-color-red mdui-m-t-1">警告:请谨慎对角色进行编辑修改等操作.</div>
    <form action="{{route('adminRoleUpdate',$role->id)}}" method="post">
        {{csrf_field()}}
        <div class="mdui-row">
            <div class="mdui-textfield mdui-textfield-floating-label mdui-col-xs-12 mdui-col-sm-10 mdui-col-md-6">
                <h3 class="admin-index-title mdui-text-color-indigo">1.角色名称</h3>
                <input class="mdui-textfield-input" name="name" type="text" value="{{$role->name}}" required/>
                <div class="mdui-textfield-error">角色名称是必须的</div>
            </div>
        </div>

        <h3 class="admin-index-title mdui-text-color-indigo mdui-m-t-3 mdui-m-b-1">2.此角色所拥有的权限
            <br><small class="show-file-title-sub">下方多选框选中即可</small>
        </h3>

        <div class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">权限</label>
                <div class="layui-input-block">
                    @foreach($permissions as $permission)
                        <input type="checkbox" name="permission_id[]" value="{{$permission->id}}" title="{{$permission->name}}"  @if($permission->hasRole($role)) checked @endif >
                    @endforeach
                </div>
            </div>
        </div>


        <div class="mdui-divider" style="margin-top: 50px"></div>
        <button type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-pink-accent admin-btn"><i class="mdui-icon material-icons mdui-icon-left">edit</i>确认编辑</button>
        <a href="{{route('adminShowRolesList')}}" class="mdui-btn mdui-btn-raised mdui-ripple admin-btn"><i class="mdui-icon material-icons mdui-icon-left">arrow_back</i>返回到角色列表</a>
        <div class="mdui-divider" style="margin-bottom: 200px"></div>

    </form>


@endsection