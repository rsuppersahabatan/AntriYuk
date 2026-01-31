<x-layout title="Kelola Pengguna">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Pengguna</h1>
        </div>

        <div class="bg-white rounded-xl border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-medium text-slate-500 uppercase">Nama</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-slate-500 uppercase">Email</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-slate-500 uppercase">Role</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-slate-500 uppercase">Lokasi</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $user->role === 'operator' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $user->role === 'viewer' ? 'bg-slate-100 text-slate-800' : '' }}
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $user->location?->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="text-sm border border-slate-300 rounded px-2 py-1">
                                            <option value="viewer" {{ $user->role === 'viewer' ? 'selected' : '' }}>Viewer</option>
                                            <option value="operator" {{ $user->role === 'operator' ? 'selected' : '' }}>Operator</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <select name="location_id" class="text-sm border border-slate-300 rounded px-2 py-1">
                                            <option value="">-- Tanpa Lokasi --</option>
                                            @foreach($locations as $loc)
                                                <option value="{{ $loc->id }}" {{ $user->location_id === $loc->id ? 'selected' : '' }}>
                                                    {{ $loc->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
