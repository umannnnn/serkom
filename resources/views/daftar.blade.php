@extends('layouts.app')

@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white text-center">Daftar Beasiswa</h2>
        <form action="{{ route('daftar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukan Nama</label>
                    <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Nama Anda" value="{{ old('nama') }}" placeholder="Masukan Nama Anda" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukan Email</label>
                    <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 {{ $errors->has('email') ? 'border-red-500' : '' }}" placeholder="Masukan Email Anda" value="{{ old('email') }}" required="">
                    @if ($errors->has('email'))
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $errors->first('email') }}</p>
                    @endif
                </div>                
                <div class="sm:col-span-2">
                    <label for="nomor_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor HP</label>
                    <input type="number" name="nomor_hp" id="nomor_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 {{ $errors->has('nomor_hp') ? 'border-red-500' : '' }}" placeholder="083123124155" value="{{ old('nomor_hp') }}" required="">
                    @if ($errors->has('nomor_hp'))
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $errors->first('nomor_hp') }}</p>
                    @endif
                </div>                
                <div>
                    <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester saat ini</label>
                    <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" onchange="updateIPK()">
                        <option value="" disabled selected>Pilih Semester</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}">{{ $semester->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ipk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IPK terakhir</label>
                    <input type="number" name="ipk" id="ipk" value="{{ old('ipk') }}" autocomplete="ipk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly required="">
                </div> 
                <div class="sm:col-span-2">
                    <label for="beasiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilihan Beasiswa</label>
                    <select id="beasiswa" name="beasiswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="" disabled selected>Pilih Beasiswa</option>
                        @foreach ($beasiswas as $beasiswa)
                            <option value="{{ $beasiswa->id }}">{{ $beasiswa->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload Berkas Syarat</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="berkas" autocomplete="berkas" aria-describedby="user_avatar_help" id="berkas" type="file">
                </div>
            </div>
            <button id="simpan" class="items-center px-5 py-2.5 mt-5 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg ">
                Daftar
            </button>
        </form>
    </div>
</section>

<script>
    // menampilkan ipk
    var ipkValues = <?php echo json_encode($semesters); ?>;
    // menampilkan ipk
    function updateIPK() {
        // mendapatkan id semester
        var selectedSemesterId = document.getElementById("semester").value;
        // mencari semester yang dipilih
        var selectedSemester = ipkValues.find(function(semester) {
            // mencocokan id semester
            return semester.id == selectedSemesterId;
        });
        // menampilkan ipk
        if (selectedSemester) {
            // menampilkan ipk
            document.getElementById("ipk").value = selectedSemester.ipk;
            // menampilkan beasiswa
            if (selectedSemester.ipk < 3) {
                // menampilkan beasiswa
                document.getElementById("beasiswa").disabled = true;
                const berkas = document.getElementById("berkas");
                berkas.disabled = true;
                // menampilkan tombol
                const tombol = document.getElementById("simpan");
                tombol.disabled = true;
                tombol.classList.remove("bg-blue-300");
                tombol.classList.add("bg-gray-300");
            }else{
                // menampilkan beasiswa
                const beasiswa = document.getElementById("beasiswa");
                beasiswa.disabled = false;
                beasiswa.focus();
                // menampilkan berkas
                const berkas = document.getElementById("berkas");
                berkas.disabled = false;
                // menampilkan tombol
                const tombol = document.getElementById("simpan");
                tombol.disabled = false;
                tombol.classList.add("bg-blue-700");
                tombol.classList.remove("bg-gray-300");
            }
        }
    }
</script>

@endsection