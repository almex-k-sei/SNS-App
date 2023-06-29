    <head>
        <link rel="stylesheet" href="css/dashboard.css">
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="dashboard_container">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("プロフィールを登録しましょう！") }}
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                            名前<br><input type="text" name="name" placaholder="名前">
                            プロフィール画像<br><input type="file" name="image" placeholder="プロフィール画像">
                            誕生日<br><input type="date" name="birth" placeholder="誕生日">
                            ひとこと<br><input type="text" name="description" placeholder="ひとこと">
                            <div class="completion">
                                <input type="submit" value="完了">
                            </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
