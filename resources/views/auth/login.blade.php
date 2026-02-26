<x-layout title="Masuk">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Masuk ke AntriYuk</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-2">Masuk untuk mengakses dashboard operator atau admin</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                        @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                        @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-slate-700 dark:text-slate-300">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-slate-600 text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Daftar</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
