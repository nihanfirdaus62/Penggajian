<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Pengajuan BLT - Metode SAW + AI</title>
    
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Custom scrollbar for a better look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        /* Simple transition for view switching */
        .view {
            transition: opacity 0.3s ease-in-out;
        }
        /* Active sidebar link style */
        .sidebar-link.active {
            background-color: #4f46e5;
            color: white;
        }
        .spinner {
            border-top-color: #3498db;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Login Page -->
    <div id="loginPage" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 p-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 space-y-6 transform transition-all hover:scale-105 duration-300">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Admin Login</h1>
                <p class="text-gray-500 mt-2">Sistem Pendukung Keputusan BLT</p>
            </div>
            <form onsubmit="event.preventDefault(); handleLogin();">
                <div class="space-y-4">
                    <div>
                        <label for="username" class="text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" value="admin" class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" value="password" class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
                <button type="submit" class="w-full mt-8 flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:translate-y-[-2px]">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <!-- Main Application (Initially Hidden) -->
    <div id="mainApp" class="hidden">
        <div class="flex h-screen bg-gray-100">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 text-white flex flex-col">
                <div class="h-20 flex items-center justify-center border-b border-gray-700">
                    <h1 class="text-2xl font-bold">SPK BLT SAW</h1>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="#" onclick="showView('dashboardView')" class="sidebar-link group flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-700 active">Dashboard</a>
                    <a href="#" onclick="showView('pengajuanView')" class="sidebar-link group flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-700">Form Pengajuan</a>
                    <a href="#" onclick="showView('kriteriaView')" class="sidebar-link group flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-700">Manajemen Kriteria</a>
                </nav>
                 <div class="p-4 border-t border-gray-700">
                    <button onclick="handleLogout()" class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Logout
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6 lg:p-10 overflow-y-auto">
                
                <!-- Dashboard & Ranking View -->
                <div id="dashboardView" class="view">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard & Hasil Perankingan</h2>
                    
                    <!-- Gemini AI Summary Section -->
                    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                        <div class="flex justify-between items-start">
                             <h3 class="text-xl font-semibold text-gray-700 mb-4">Ringkasan Analisis AI</h3>
                             <button id="generateSummaryBtn" onclick="handleGenerateSummary()" class="flex items-center gap-2 bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:scale-105 transform transition-transform duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                 ✨ Analisis Hasil dengan AI
                             </button>
                        </div>
                         <div id="aiSummaryResult" class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-lg text-gray-600 text-sm leading-relaxed whitespace-pre-wrap min-h-[100px]">
                            Klik tombol untuk menghasilkan ringkasan...
                         </div>
                    </div>

                    <!-- Data Awal -->
                    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">1. Data Awal Pemohon</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggungan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penghasilan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi Rumah</th>
                                    </tr>
                                </thead>
                                <tbody id="applicantsTable" class="bg-white divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Perhitungan SAW -->
                    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">2. Matriks Normalisasi (R)</h3>
                         <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">C1</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">C2</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">C3</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">C4</th>
                                    </tr>
                                </thead>
                                <tbody id="normalizationTable" class="bg-white divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Hasil Akhir -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">3. Hasil Akhir Perankingan</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai (V)</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Justifikasi AI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rankingTable" class="bg-white divide-y divide-gray-200">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Grafik Hasil -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">Grafik Hasil Perankingan</h3>
                            <canvas id="rankingChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Application Form View -->
                <div id="pengajuanView" class="view hidden">
                    <!-- ... existing form code ... -->
                </div>

                <!-- Criteria Management View -->
                <div id="kriteriaView" class="view hidden">
                     <!-- ... existing criteria code ... -->
                </div>

            </main>
        </div>
    </div>
    
    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg transform translate-y-20 opacity-0 transition-all duration-300">
        Data berhasil ditambahkan!
    </div>
    
    <!-- AI Justification Modal -->
    <div id="justificationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Justifikasi AI untuk <span id="modalApplicantName" class="text-indigo-600"></span></h3>
            <div id="modalContent" class="text-sm text-gray-600 bg-gray-50 p-4 rounded-md min-h-[150px] whitespace-pre-wrap">
                <!-- Justification content goes here -->
            </div>
            <button onclick="closeModal()" class="mt-6 w-full py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">Tutup</button>
        </div>
    </div>


<script>
    // --- DATA & KONFIGURASI ---
    const criteria = [
        { id: 'C1', name: 'Jumlah Tanggungan', weight: 0.35, type: 'benefit' },
        { id: 'C2', name: 'Penghasilan', weight: 0.30, type: 'cost' },
        { id: 'C3', name: 'Aset Kepemilikan', weight: 0.20, type: 'cost' },
        { id: 'C4', name: 'Kondisi Rumah', weight: 0.15, type: 'cost' }
    ];

    let applicants = [
        { name: 'Budi Santoso', values: { C1: 5, C2: 1, C3: 1, C4: 2 } },
        { name: 'Siti Aminah', values: { C1: 3, C2: 2, C3: 2, C4: 3 } },
        { name: 'Agus Wijoyo', values: { C1: 2, C2: 4, C3: 4, C4: 4 } },
        { name: 'Dewi Lestari', values: { C1: 4, C2: 2, C3: 1, C4: 1 } },
        { name: 'Eko Prabowo', values: { C1: 3, C2: 3, C3: 3, C4: 3 } }
    ];
    let rankedResultsCache = [];
    let chartInstance = null;
    
    // --- GEMINI API INTEGRATION ---
    const API_KEY = ""; // Keep empty
    const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key=${API_KEY}`;
    
    async function callGeminiAPI(prompt) {
        try {
            const payload = {
                contents: [{ parts: [{ text: prompt }] }],
            };
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            if (!response.ok) {
                 const errorBody = await response.json();
                 console.error("API Error Response:", errorBody);
                 return `Error: ${response.status} - ${errorBody.error?.message || 'Gagal berkomunikasi dengan API.'}`;
            }
            const result = await response.json();
            return result.candidates?.[0]?.content?.parts?.[0]?.text || "Tidak ada respons dari AI.";
        } catch (error) {
            console.error("Error calling Gemini API:", error);
            return "Terjadi kesalahan saat menghubungi layanan AI.";
        }
    }

    async function handleGenerateSummary() {
        const btn = document.getElementById('generateSummaryBtn');
        const resultContainer = document.getElementById('aiSummaryResult');
        btn.disabled = true;
        resultContainer.innerHTML = `<div class="flex items-center justify-center h-full"><div class="spinner w-8 h-8 border-4 rounded-full"></div><span class="ml-3">Menganalisis data...</span></div>`;

        const rankingText = rankedResultsCache.map((r, i) => `${i+1}. ${r.name} (Skor: ${r.score.toFixed(4)})`).join('\n');
        
        const prompt = `Anda adalah seorang analis bantuan sosial yang berpengalaman. Tugas Anda adalah memberikan ringkasan yang jelas, objektif, dan profesional.
        Berdasarkan data peringkat penerima Bantuan Langsung Tunai (BLT) berikut, berikan ringkasan analisis.

        Kriteria dan bobot yang digunakan:
        - Jumlah Tanggungan (Bobot: 35%, Semakin banyak semakin baik)
        - Penghasilan (Bobot: 30%, Semakin sedikit semakin baik)
        - Aset (Bobot: 20%, Semakin sedikit semakin baik)
        - Kondisi Rumah (Bobot: 15%, Semakin buruk semakin baik)

        Hasil Peringkat:
        ${rankingText}

        Analisis Anda harus mencakup:
        1. Kesimpulan umum mengenai hasil peringkat.
        2. Identifikasi 2-3 kandidat teratas dan jelaskan secara singkat mengapa mereka mendapatkan skor tertinggi.
        3. Berikan rekomendasi singkat mengenai kelayakan para penerima.`;

        const summary = await callGeminiAPI(prompt);
        resultContainer.textContent = summary;
        btn.disabled = false;
    }
    
    async function handleGenerateJustification(applicantName) {
        const applicant = applicants.find(a => a.name === applicantName);
        if (!applicant) return;

        document.getElementById('modalApplicantName').textContent = applicantName;
        const modalContent = document.getElementById('modalContent');
        const modal = document.getElementById('justificationModal');
        modal.classList.remove('hidden');
        modalContent.innerHTML = `<div class="flex items-center justify-center h-full"><div class="spinner w-6 h-6 border-4 rounded-full"></div><span class="ml-3">Membuat justifikasi...</span></div>`;

        const kriteriaDesc = {
            C1: `Jumlah Tanggungan: ${applicant.values.C1} (dari 5, 5=sangat banyak)`,
            C2: `Penghasilan: ${applicant.values.C2} (dari 5, 1=sangat rendah)`,
            C3: `Aset Kepemilikan: ${applicant.values.C3} (dari 5, 1=tidak punya)`,
            C4: `Kondisi Rumah: ${applicant.values.C4} (dari 5, 1=tidak layak huni)`,
        }
        
        const prompt = `Anda adalah staf administrasi yang bertugas membuat justifikasi formal untuk keputusan penerimaan Bantuan Langsung Tunai (BLT).
        Buatkan paragraf justifikasi formal untuk seorang pemohon BLT bernama ${applicant.name}. Berikut adalah data pemohon:
        - ${kriteriaDesc.C1}
        - ${kriteriaDesc.C2}
        - ${kriteriaDesc.C3}
        - ${kriteriaDesc.C4}

        Jelaskan mengapa pemohon ini direkomendasikan untuk mendapatkan prioritas bantuan berdasarkan kombinasi dari faktor-faktor tersebut secara formal dan objektif dalam satu paragraf singkat.`;

        const justification = await callGeminiAPI(prompt);
        modalContent.textContent = justification;
    }
    
    function closeModal() {
        document.getElementById('justificationModal').classList.add('hidden');
    }

    // --- FUNGSI TAMPILAN (UI) ---

    function handleLogin() {
        document.getElementById('loginPage').classList.add('hidden');
        document.getElementById('mainApp').classList.remove('hidden');
        initializeApp();
    }
    
    function handleLogout() {
        document.getElementById('loginPage').classList.remove('hidden');
        document.getElementById('mainApp').classList.add('hidden');
    }

    function showView(viewId) {
        document.querySelectorAll('.view').forEach(view => view.classList.add('hidden'));
        document.getElementById(viewId).classList.remove('hidden');
        document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
        document.querySelector(`.sidebar-link[onclick="showView('${viewId}')"]`).classList.add('active');
    }
    
    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    // --- FUNGSI RENDER DATA ---

    function renderCriteriaTable() {
        // This function can be copied from the previous version
    }

    function renderApplicantsTable() {
        // This function can be copied from the previous version
    }

    function renderNormalizationTable(normalizedMatrix) {
       // This function can be copied from the previous version
    }

    function renderRankingTable(rankedResults) {
        const tableBody = document.getElementById('rankingTable');
        tableBody.innerHTML = '';
        rankedResults.forEach((result, index) => {
            const rankClass = index === 0 ? 'bg-green-100 font-bold' : (index === 1 ? 'bg-yellow-100' : (index === 2 ? 'bg-orange-100' : ''));
            tableBody.innerHTML += `
                <tr class="${rankClass} hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${index + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${result.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">${result.score.toFixed(4)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <button onclick="handleGenerateJustification('${result.name}')" class="text-xs bg-indigo-100 text-indigo-700 font-semibold py-1 px-3 rounded-full hover:bg-indigo-200">
                           ✨ Buat Justifikasi
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    function renderRankingChart(rankedResults) {
       // This function can be copied from the previous version
    }

    // --- LOGIKA PERHITUNGAN SAW ---
    function calculateSAW() {
        if (applicants.length === 0) {
            // ... (clear table logic)
            return;
        }

        const extrema = {};
        criteria.forEach(c => {
            const values = applicants.map(a => a.values[c.id]);
            extrema[c.id] = c.type === 'benefit' ? Math.max(...values) : Math.min(...values);
        });

        const normalizedMatrix = applicants.map(a => {
            const normalizedValues = {};
            criteria.forEach(c => {
                normalizedValues[c.id] = c.type === 'benefit' ? (a.values[c.id] / extrema[c.id]) : (extrema[c.id] / a.values[c.id]);
            });
            return { name: a.name, values: normalizedValues };
        });

        const results = normalizedMatrix.map(row => {
            let score = criteria.reduce((acc, c) => acc + (row.values[c.id] * c.weight), 0);
            return { name: row.name, score: score };
        });

        rankedResultsCache = results.sort((a, b) => b.score - a.score);

        renderNormalizationTable(normalizedMatrix);
        renderRankingTable(rankedResultsCache);
        renderRankingChart(rankedResultsCache);
    }

    // --- EVENT HANDLERS & INISIALISASI ---
    function handleFormSubmit(event) {
        event.preventDefault();
        // ... (form submission logic)
        
        // After adding data, reset AI summary
        document.getElementById('aiSummaryResult').innerHTML = "Klik tombol untuk menghasilkan ringkasan...";
    }
    
    function initializeApp() {
        // I've omitted the full code for functions that are identical to the previous version for brevity.
        // You should copy the full implementation of these functions from the original file:
        // - renderCriteriaTable()
        // - renderApplicantsTable()
        // - renderNormalizationTable(normalizedMatrix)
        // - renderRankingChart(rankedResults)
        // - handleFormSubmit(event)
        
        // This is a placeholder to demonstrate where to put the original functions
        const placeholderRenderFunctions = () => {
            renderCriteriaTable = function() {
                const tableBody = document.getElementById('criteriaTable');
                if(!tableBody) return;
                tableBody.innerHTML = '';
                criteria.forEach(c => {
                    const typeClass = c.type === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                    tableBody.innerHTML += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${c.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${c.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${c.weight}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${typeClass}">${c.type.toUpperCase()}</span>
                            </td>
                        </tr>`;
                });
            }
            renderApplicantsTable = function() {
                const tableBody = document.getElementById('applicantsTable');
                if(!tableBody) return;
                tableBody.innerHTML = '';
                applicants.forEach(a => {
                    tableBody.innerHTML += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${a.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${a.values.C1}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${a.values.C2}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${a.values.C3}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${a.values.C4}</td>
                        </tr>`;
                });
            }
            renderNormalizationTable = function(normalizedMatrix) {
                 const tableBody = document.getElementById('normalizationTable');
                 if(!tableBody) return;
                tableBody.innerHTML = '';
                normalizedMatrix.forEach(row => {
                    tableBody.innerHTML += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${row.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.values.C1.toFixed(3)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.values.C2.toFixed(3)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.values.C3.toFixed(3)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.values.C4.toFixed(3)}</td>
                        </tr>`;
                });
            }
            renderRankingChart = function(rankedResults) {
                const ctx = document.getElementById('rankingChart').getContext('2d');
                if (chartInstance) chartInstance.destroy();
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: rankedResults.map(r => r.name),
                        datasets: [{
                            label: 'Nilai Preferensi (V)',
                            data: rankedResults.map(r => r.score),
                            backgroundColor: 'rgba(79, 70, 229, 0.8)',
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } },
                        plugins: { legend: { display: false } }
                    }
                });
            }
             handleFormSubmit = function(event) {
                event.preventDefault();
                const newApplicant = {
                    name: document.getElementById('nama').value,
                    values: {
                        C1: parseInt(document.getElementById('tanggungan').value),
                        C2: parseInt(document.getElementById('penghasilan').value),
                        C3: parseInt(document.getElementById('aset').value),
                        C4: parseInt(document.getElementById('kondisi_rumah').value)
                    }
                };
                applicants.push(newApplicant);
                document.getElementById('submissionForm').reset();
                showToast('Data pemohon baru berhasil ditambahkan!');
                renderApplicantsTable();
                calculateSAW();
                showView('dashboardView');
                document.getElementById('aiSummaryResult').innerHTML = "Data telah diperbarui. Klik tombol untuk menghasilkan ringkasan baru...";
            }
        };
        placeholderRenderFunctions(); // Run the placeholder to define functions
        
        renderCriteriaTable();
        renderApplicantsTable();
        calculateSAW();
        
        // Re-locate and ensure form is only accessible in 'pengajuanView'
        const submissionForm = document.querySelector('#pengajuanView form');
        if (submissionForm) {
            submissionForm.id = 'submissionForm';
             submissionForm.addEventListener('submit', handleFormSubmit);
        }
        
        showView('dashboardView');
    }

</script>

</body>
</html>

