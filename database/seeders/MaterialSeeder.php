<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Materials for Course 1 (Laravel)
        Material::create([
            'course_id' => 1,
            'judul' => 'Pengenalan Laravel Framework',
            'deskripsi' => 'Video pengenalan Laravel framework dan ecosystem-nya',
            'tipe' => 'article',
            'file_url' => '<h2>Pengenalan Laravel Framework</h2><p>Laravel adalah framework PHP yang elegant dan powerful untuk membangun aplikasi web modern. Framework ini dikembangkan oleh Taylor Otwell dan pertama kali dirilis pada tahun 2011.</p><h3>Keunggulan Laravel:</h3><ul><li>Sintaks yang ekspresif dan elegant</li><li>Built-in ORM (Eloquent)</li><li>Routing yang powerful</li><li>Blade templating engine</li><li>Artisan command line tool</li><li>Security features yang lengkap</li></ul><p>Laravel menggunakan pola arsitektur MVC (Model-View-Controller) yang membantu developer dalam mengorganisir kode dengan baik.</p>',
            'status' => 'approved',
            'user_id' => 2,
        ]);

        Material::create([
            'course_id' => 1,
            'judul' => 'Instalasi dan Setup Laravel',
            'deskripsi' => 'Panduan instalasi Laravel dan konfigurasi environment',
            'tipe' => 'article',
            'file_url' => '<h2>Instalasi Laravel</h2><p>Ada beberapa cara untuk menginstall Laravel:</p><h3>1. Via Composer Create-Project</h3><pre><code>composer create-project laravel/laravel nama-project</code></pre><h3>2. Via Laravel Installer</h3><pre><code>composer global require laravel/installer<br>laravel new nama-project</code></pre><h3>Konfigurasi Environment</h3><p>Setelah instalasi, copy file .env.example menjadi .env dan generate application key:</p><pre><code>cp .env.example .env<br>php artisan key:generate</code></pre><p>Jangan lupa untuk mengkonfigurasi database di file .env.</p>',
            'status' => 'approved',
            'user_id' => 2,
        ]);

        // Materials for Course 2 (React)
        Material::create([
            'course_id' => 2,
            'judul' => 'React Hooks Deep Dive',
            'deskripsi' => 'Pembahasan mendalam mengenai React Hooks',
            'tipe' => 'article',
            'file_url' => '<h2>React Hooks</h2><p>React Hooks adalah fitur yang diperkenalkan di React 16.8 yang memungkinkan kita menggunakan state dan lifecycle methods di functional components.</p><h3>Hook Dasar:</h3><ul><li><strong>useState</strong> - untuk mengelola state</li><li><strong>useEffect</strong> - untuk side effects</li><li><strong>useContext</strong> - untuk mengakses React context</li></ul><h3>Contoh useState:</h3><pre><code>const [count, setCount] = useState(0);</code></pre><h3>Contoh useEffect:</h3><pre><code>useEffect(() => {<br>  document.title = `Count: ${count}`;<br>}, [count]);</code></pre>',
            'status' => 'approved',
            'user_id' => 3,
        ]);

        Material::create([
            'course_id' => 2,
            'judul' => 'State Management dengan Redux',
            'deskripsi' => 'Pengelolaan state global menggunakan Redux',
            'tipe' => 'article',
            'file_url' => '<h2>Redux State Management</h2><p>Redux adalah library untuk mengelola state aplikasi JavaScript. Redux menggunakan pola Flux architecture.</p><h3>Core Concepts:</h3><ul><li><strong>Store</strong> - tempat menyimpan state</li><li><strong>Actions</strong> - objek yang mendeskripsikan perubahan</li><li><strong>Reducers</strong> - pure functions yang mengubah state</li></ul><h3>Contoh Action:</h3><pre><code>const increment = () => ({<br>  type: "INCREMENT"<br>});</code></pre><h3>Contoh Reducer:</h3><pre><code>const counter = (state = 0, action) => {<br>  switch (action.type) {<br>    case "INCREMENT":<br>      return state + 1;<br>    default:<br>      return state;<br>  }<br>};</code></pre>',
            'status' => 'approved',
            'user_id' => 3,
        ]);

        // Materials for Course 3 (Database)
        Material::create([
            'course_id' => 3,
            'judul' => 'Database Normalization',
            'deskripsi' => 'Konsep normalisasi database dan bentuk normal',
            'tipe' => 'article',
            'file_url' => '<h2>Database Normalization</h2><p>Normalisasi adalah proses mengorganisir data dalam database untuk mengurangi redundansi dan meningkatkan integritas data.</p><h3>Bentuk Normal:</h3><h4>First Normal Form (1NF)</h4><ul><li>Setiap kolom harus atomic (tidak dapat dibagi lagi)</li><li>Tidak ada repeating groups</li></ul><h4>Second Normal Form (2NF)</h4><ul><li>Sudah dalam 1NF</li><li>Semua non-key attributes bergantung penuh pada primary key</li></ul><h4>Third Normal Form (3NF)</h4><ul><li>Sudah dalam 2NF</li><li>Tidak ada transitive dependency</li></ul><p>Normalisasi membantu mengurangi duplikasi data dan menjaga konsistensi database.</p>',
            'status' => 'approved',
            'user_id' => 4,
        ]);
    }
} 