<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="{{ asset('css/client/register.css') }}">
</head>

<body>
    <div class="signup">
        <div class="signIn-image">
        </div>
        <div class="signup-classic">
            <h2>Sign up</h2>
            <form action="{{ url('/register') }}" method="post" id="signup-form" enctype="multipart/form-data">
                @csrf
                <div class="group-form">
                    <div class="form-row">
                        <label for="name">Username:</label>
                        <input type="text" name="name" id="name" style="width:70%">
                    </div>

                    <div class="form-row">
                        <label for="fullname">Fullname:</label>
                        <input type="text" name="fullname" id="fullname" style="width:90%">
                    </div>

                </div>

                <div class="form-row">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="+12 characters">
                </div>

                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com">
                </div>

                <div class="form-row">
                    <label for="major">Major:</label>
                    <input type="text" name="major" id="major">
                </div>

                <div class="form-row" style="gap: 20px;display: flex;flex-direction: row;">
                    <div class="form-select">
                        <label for="birthdate">Date:</label>
                        <select name="birthdate" id="birthdate">
                            @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="form-select">
                        <label for="birthmonth">Month:</label>
                        <select name="birthmonth" id="birthmonth">
                            @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}">
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                                @endfor
                        </select>
                    </div>
                    <div class="form-select">
                        <label for="birthyear">Year:</label>
                        <select name="birthyear" id="birthyear">
                            @for ($i = date('Y'); $i >= 1900; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <label for="path">Path:</label>
                    <input type="file" id="path" name="path" accept="image/*">
                </div>

                <input type="submit" value="Register" name="register">
            </form>
        </div>
    </div>
</body>

</html>