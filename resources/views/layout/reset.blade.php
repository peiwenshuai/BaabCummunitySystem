<div class="reset-dialog mdui-dialog" id="reset-dialog">
    <button class="mdui-btn mdui-btn-icon mdui-text-color-white close" mdui-dialog-close>
            <i class="mdui-icon material-icons">close</i>
    </button>
    <div class="mdui-dialog-title reset-bg mdui-text-color-white">
        <div class="dialog-title">
            {{__('auth.resetPassword')}}
        </div>
    </div>
    <div class="" id="resetForm">
        @if(!Auth::check())
            <div class="mdui-textfield mdui-textfield-floating-label mdui-textfield-has-bottom" id="resetEmailTextField">
                <i class="mdui-icon material-icons">email</i>
                <label class="mdui-textfield-label">{{__('auth.email')}}</label>
                <input class="mdui-textfield-input" name="resetEmail" type="email" required>
                <div class="mdui-textfield-error" id="resetEmailError">{{__('auth.emailError')}}</div>
            </div>
            <div class="actions">
                <button type="button" class="mdui-btn mdui-ripple more-option" mdui-menu="{target: '#password-reset-menu', position: 'top', covered: false}">{{__('auth.moreOptions')}}</button>
                <ul class="mdui-menu full-width-menu" id="password-reset-menu">
                    <li class="mdui-menu-item">
                        <a onclick="resetToLogin()" class="mdui-ripple">{{__('index.login')}}</a>
                    </li>
                    <li class="mdui-menu-item">
                        <a onclick="resetToRegister()" class="mdui-ripple">{{__('auth.createAccount')}}</a>
                    </li>
                </ul>
                <a onclick="resetSubmit()" class="mdui-btn mdui-btn-raised mdui-color-theme-accent mdui-float-right" id="resetSubmitBtn">{{__('index.next')}}</a>
                <a class="mdui-btn mdui-btn-icon mdui-float-right mdui-m-r-1 mdui-text-color-grey-600" mdui-dialog-close>
                    <i class="mdui-icon material-icons">arrow_back</i>
                </a>
            </div>
        @else
            <img class="dialog-center-avatar" src="{{Auth::user()->info->avatar_url}}">
            <div class="dialog-center-h1-small mdui-text-color-grey">
                {{Auth::user()->email}}
            </div>
            <div class="dialog-center-h1 mdui-text-color-indigo">
                {{__('auth.resetPasswordSendEmailTip')}}
            </div>
            <input class="mdui-hidden" name="resetEmail" type="email" value="{{Auth::user()->email}}" required>
            <button onclick="resetSubmit()" class="mdui-btn mdui-btn-dense mdui-btn-raised mdui-m-t-5 mdui-ripple mdui-color-pink-400 mdui-center" id="resetSubmitBtn">{{__('auth.confirmToChange')}}</button>
        @endif
    </div>
    <div id="resetSendSuccessful" class="mdui-valign success mdui-hidden">
        <div class="mdui-center">
            <i class="mdui-icon material-icons mdui-text-color-teal mdui-center icon" id="resetSuccessIcon">&#xe862;</i>
            <h3 class="mdui-center mdui-m-t-2">
                We have sent confirmation mail to your mailbox.
            </h3>
            <h3 class="mdui-center mdui-m-t-1">
                Please follow the prompts in the email to continue.
            </h3>
            <div class="btns">
                <button onclick="resetToLogin()" class="mdui-btn mdui-btn-dense mdui-btn-raised mdui-ripple mdui-color-pink-400">Login after success</button>
            </div>
        </div>
    </div>
</div>