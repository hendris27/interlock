<x-app-layout title="Backend · Interlock System">
    <style>
        header {
            padding: 4.8rem 1rem 3.8rem;
            margin-left: 235px;
            text-align: center;
            position: relative;
            z-index: 1;
            transition: margin-left .28s ease;
        }

        .sidebar-toggle {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            display: grid;
            place-items: center;
            width: 2.3rem;
            height: 2.3rem;
            color: #fff;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 7px;
            cursor: pointer;
            font-size: 1.2rem;
            line-height: 1;
            transition: left .28s ease, right .28s ease, background .2s ease, transform .2s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, .24);
            transform: scale(1.04);
        }

        .sidebar-toggle:focus-visible {
            outline: 3px solid rgba(255, 255, 255, .45);
            outline-offset: 3px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .7rem;
            margin: 0;
            font-size: clamp(1.7rem, 3vw, 2.5rem);
            font-weight: 700;
            letter-spacing: .01em;
        }

        main {
            min-height: calc(100dvh - 12rem);
            margin-left: 235px;
            position: relative;
            z-index: 1;
            transition: margin-left .28s ease;
        }

        .page.sidebar-hidden .sidebar {
            left: -235px;
        }

        .page.sidebar-hidden header,
        .page.sidebar-hidden main {
            margin-left: 0;
        }

        .page.sidebar-hidden .sidebar-toggle {
            position: fixed;
            z-index: 5;
            top: 1.25rem;
            right: auto;
            left: 1rem;
        }

        html,
        body {
            overflow-x: hidden;
            overflow-y: hidden;
        }

        form {
            min-height: calc(100dvh - 12rem);
            max-height: calc(100dvh - 130px);
            overflow: hidden;
        }

        .controls {
            display: grid;
            grid-template-columns: 250px minmax(280px, 1fr);
            gap: 2.4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .control {
            height: 56px;
            border: 1px solid rgba(255, 255, 255, .45);
            border-radius: 8px;
            background: #fff;
            color: var(--ink);
            font: .82rem Arial, sans-serif;
            box-shadow: 0 8px 22px rgba(3, 25, 56, .13);
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .control:focus-within,
        .control:focus {
            border-color: #fff;
            outline: 3px solid rgba(255, 255, 255, .2);
            outline-offset: 1px;
        }

        .model-picker {
            position: relative;
            display: flex;
            align-items: stretch;
            height: auto;
            min-height: 56px;
            padding: 0;
            overflow: visible;
        }

        .model-input-wrap {
            display: flex;
            align-items: center;
            width: 100%;
            min-height: 56px;
            border-radius: 8px;
            overflow: hidden;
        }

        .model-search-input {
            flex: 1;
            min-width: 0;
            height: 56px;
            padding: 0 1rem;
            border: 0;
            outline: 0;
            background: #fff;
            color: var(--ink);
            text-align: center;
            font: inherit;
        }

        .search-btn {
            width: 110px;
            height: 56px;
            border: 0;
            border-left: 1px solid rgba(16, 36, 61, .12);
            background: var(--blue);
            color: #fff;
            font: 700 .76rem Arial, sans-serif;
            cursor: pointer;
            transition: background .2s ease, filter .2s ease;
        }

        .search-btn:hover {
            background: #0d5cb4;
            filter: brightness(1.02);
        }

        .model-dropdown {
            position: absolute;
            z-index: 35;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            display: none;
            max-height: 260px;
            overflow-y: auto;
            padding: .35rem;
            background: rgba(9, 31, 58, .96);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 10px;
            box-shadow: 0 14px 30px rgba(1, 16, 39, .28);
        }

        .model-dropdown.visible {
            display: block;
        }

        .model-option {
            display: block;
            width: 100%;
            padding: .7rem .8rem;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #edf7ff;
            text-align: left;
            font: .78rem Arial, sans-serif;
            cursor: pointer;
        }

        .model-option:hover,
        .model-option:focus-visible {
            background: rgba(255, 255, 255, .08);
            outline: none;
        }

        .line-select {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .line-select select {
            width: 100%;
            height: 100%;
            padding: 0 3.5rem 0 1rem;
            border: 0;
            outline: 0;
            appearance: none;
            background: transparent;
            color: inherit;
            text-align: center;
            font: inherit;
            cursor: pointer;
        }

        .line-search {
            width: 100%;
            height: 100%;
            padding: 0 3.5rem 0 1rem;
            border: 0;
            outline: 0;
            background: transparent;
            color: inherit;
            text-align: center;
            font: inherit;
        }

        .line-select::after {
            content: '';
            position: absolute;
            right: 1.3rem;
            top: 50%;
            width: 8px;
            height: 8px;
            border-right: 2px solid var(--blue);
            border-bottom: 2px solid var(--blue);
            transform: translateY(-70%) rotate(45deg);
            pointer-events: none;
        }

        .search {
            width: 100%;
            padding: 0 1.25rem;
            text-align: center;
            background: #fff;
            color: var(--ink);
        }

        .search::placeholder,
        .scan-input::placeholder {
            color: #8493a3;
            opacity: 1;
        }

        .search::-webkit-calendar-picker-indicator {
            opacity: 0.8;
            cursor: pointer;
            filter: grayscale(1) brightness(0.5);
        }

        .scan-area {
            width: min(100%, 390px);
            margin: 3.2rem auto 0;
        }

        .scan-progress,
        .scan-input {
            width: 100%;
            height: 64px;
            border: 1px solid rgba(255, 255, 255, .45);
            border-radius: 9px;
            background: #fff;
            text-align: center;
            font: .82rem Arial, sans-serif;
            box-shadow: 0 8px 22px rgba(3, 25, 56, .13);
        }

        .scan-progress {
            position: relative;
            display: grid;
            place-items: center;
            margin-bottom: .75rem;
            color: var(--ink);
            font-weight: 700;
        }

        .scan-progress::after {
            content: '';
            position: absolute;
            right: 1.2rem;
            bottom: .8rem;
            left: 1.2rem;
            height: 3px;
            overflow: hidden;
            background: #dbeaf7;
            border-radius: 4px;
        }

        .scan-progress::before {
            content: '';
            position: absolute;
            z-index: 1;
            right: calc(25% + 1.2rem);
            bottom: .8rem;
            left: 1.2rem;
            height: 3px;
            background: var(--blue);
            border-radius: 4px;
        }

        .scan-input {
            padding: 0 1.25rem;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .scan-input:focus,
        .search:focus {
            border-color: var(--blue);
            outline: 3px solid rgba(255, 255, 255, .24);
            outline-offset: 1px;
        }

        .scan-help {
            margin: .6rem 0 0;
            color: var(--muted);
            font-size: .7rem;
            text-align: center;
        }

        .submit {
            display: block;
            width: 160px;
            height: 44px;
            margin: 1.3rem auto 0;
            border: 0;
            border-radius: 7px;
            color: #fff;
            background: var(--blue);
            cursor: pointer;
            font: 700 .78rem Arial, sans-serif;
            box-shadow: 0 6px 16px rgba(2, 34, 78, .24);
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
        }

        .submit:hover {
            background: #16915c;
            box-shadow: 0 6px 14px rgba(24, 121, 78, .3);
            transform: translateY(-1px);
        }

        .notice,
        .errors {
            width: min(100%, 390px);
            margin: 1rem auto;
            padding: .8rem 1rem;
            border: 1px solid;
            border-radius: 7px;
            font-size: .74rem;
            line-height: 1.4;
            text-align: center;
        }

        .notice {
            color: var(--green);
            background: var(--green-soft);
            border-color: rgba(168, 222, 193, .85);
        }

        .errors {
            color: #a22d35;
            background: #fff1f2;
            border-color: #e7b7bb;
        }

        .machine {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            margin: 1rem auto 0;
            font-size: 1.05rem;
            font-weight: 700;
            width: min(100%, 390px);
        }

        .machine strong {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            width: 145px;
            height: 44px;
            color: #dfeeff;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 7px;
            font-size: .78rem;
            font-weight: 700;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .05);
        }

        .machine strong::before {
            content: '';
            width: 7px;
            height: 7px;
            background: #8fe0ff;
            border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(143, 224, 255, .18);
        }

        .machine strong.locked {
            color: #dfe8f4;
            background: rgba(255, 255, 255, .08);
            border-color: rgba(255, 255, 255, .14);
        }

        .machine strong.locked::before {
            background: #b1bfd4;
            box-shadow: 0 0 0 3px rgba(177, 191, 212, .2);
        }

        footer {
            display: none;
        }

        @media (max-width: 700px) {
            .page {
                padding: 0 1rem 1.5rem;
            }

            .sidebar {
                position: relative;
                width: auto;
                padding: 1rem;
                background: rgba(2, 21, 48, .34);
                border-right: 0;
                border-bottom: 1px solid rgba(255, 255, 255, .14);
                transition: margin-left .28s ease;
            }

            .sidebar-brand {
                margin: 0 0 1rem;
            }

            .nav-label {
                display: none;
            }

            .nav-list {
                grid-template-columns: repeat(4, 1fr);
                gap: .3rem;
            }

            .nav-link {
                justify-content: center;
                padding: .65rem .3rem;
                font-size: .65rem;
                text-align: center;
            }

            .nav-link::before {
                display: none;
            }

            header {
                margin-left: 0;
                padding: 3rem .5rem 2.5rem;
            }

            .sidebar-toggle {
                position: fixed;
                z-index: 5;
                top: 1rem;
                left: 1rem;
                right: auto;
            }

            .page.sidebar-hidden .sidebar {
                left: 0;
                margin-left: -100%;
            }

            main {
                margin-left: 0;
            }

            .controls {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .scan-area,
            .notice,
            .errors {
                width: min(100%, 390px);
            }

            .machine {
                margin: 7rem 0 0;
                justify-content: center;
                gap: 1.25rem;
                font-size: .95rem;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <form id="scan" method="POST" action="{{ route('scan') }}">
            @csrf
            <div class="controls">
                <div class="control line-select">
                    <label for="line" hidden>Pilih Line</label>
                    <input class="line-search" id="line" name="line" type="search" value="{{ old('line') }}"
                        list="line-options" placeholder="Pilih Line" aria-label="Cari dan pilih Line"
                        autocomplete="off">
                    <datalist id="line-options">
                        <option value="Line 1"></option>
                        <option value="Line 2"></option>
                        <option value="Line 3"></option>
                    </datalist>
                </div>
                <div class="control model-picker" aria-label="Pilih model">
                    <label hidden for="model_name">Pilih Model</label>
                    <div class="model-input-wrap">
                        <select class="model-search-input" id="model_name" name="model_name" required>
                            <option value="">Pilih Model</option>
                            @foreach ($modelNames as $modelName)
                                <option value="{{ $modelName }}" @selected(old('model_name') === $modelName)>
                                    {{ $modelName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="scan-area">
                @if (session('success'))
                    <div class="notice" role="status">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="errors" role="alert">{{ $errors->first() }}</div>
                @endif

                <!-- Items Table -->
                <div id="items-table-container" style="display: none; margin-bottom: 2rem; width: 100%;">
                    <table
                        style="width: 100%; border-collapse: collapse; background: rgba(255, 255, 255, .08); border: 1px solid rgba(255, 255, 255, .14); border-radius: 7px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th
                                    style="padding: 1rem; text-align: left; border-bottom: 1px solid rgba(255, 255, 255, .08); background: rgba(255, 255, 255, .06); font-weight: 700; font-size: .82rem;">
                                    Item Name</th>
                                <th
                                    style="padding: 1rem; text-align: left; border-bottom: 1px solid rgba(255, 255, 255, .08); background: rgba(255, 255, 255, .06); font-weight: 700; font-size: .82rem;">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody id="items-tbody">
                        </tbody>
                    </table>
                </div>

                <div class="scan-progress" id="scan-progress-text">Scan Completed 0/0</div>
                <label hidden for="component_scan">Scan Spareparts Here</label>
                <input class="scan-input" id="component_scan" name="component_scan" type="text"
                    value="{{ old('component_scan') }}" placeholder="Scan Spareparts Here..." autofocus>
                <button class="submit" type="submit">Validasi Scan</button>
                <div class="machine">
                    <span>Machine Status :</span>
                    <strong id="machine-status" class="locked">Locked</strong>
                </div>
            </div>
        </form>

        <script>
            // Handle model search and display items
            const modelInput = document.getElementById('model_name');
            const itemsTableContainer = document.getElementById('items-table-container');
            const itemsTbody = document.getElementById('items-tbody');
            const scanProgressText = document.getElementById('scan-progress-text');
            const machineStatus = document.getElementById('machine-status');
            const scanForm = document.querySelector('form');
            const componentInput = document.getElementById('component_scan');
            const submitButton = document.querySelector('.submit');
            let scannedItems = {}; // Track scanned items
            let totalItems = 0;

            componentInput.disabled = true;
            submitButton.disabled = true;
            componentInput.placeholder = 'Pilih model terlebih dahulu';

            function updateMachineStatus(statusText = 'Locked') {
                const isLocked = statusText === 'Locked';

                machineStatus.textContent = statusText;
                machineStatus.classList.toggle('locked', isLocked);

                console.log('STATUS MACHINE:', statusText);

                fetch('/interlock/machine-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                    },
                    body: JSON.stringify({
                        status: statusText
                    })
                })
                .then(response => {
                    console.log('HTTP STATUS:', response.status);

                    return response.text().then(text => {
                        console.log('RAW RESPONSE:', text);

                        if (!response.ok) {
                            throw new Error(`HTTP Error ${response.status}: ${text}`);
                        }

                        try {
                            return JSON.parse(text);
                        } catch (error) {
                            throw new Error('Response Laravel bukan JSON: ' + text);
                        }
                    });
                })
                .then(data => {
                    console.log('LARAVEL RESPONSE:', data);
                })
                .catch(error => {
                    console.error('GAGAL KIRIM STATUS:', error);
                });
            }

            updateMachineStatus('Locked');

            function updateProgress() {
                const completedCount = Object.values(scannedItems)
                    .filter(item => item.status !== 'Pending')
                    .length;

                scanProgressText.textContent =
                    `Scan Completed ${completedCount}/${totalItems}`;

                const progressPercent =
                    totalItems > 0 ?
                    (completedCount / totalItems) * 100 :
                    0;

                if (scanProgressText.parentElement) {
                    scanProgressText.style.setProperty(
                        '--progress-percent',
                        `${progressPercent}%`
                    );
                }
            }

            async function loadModelItems(modelName) {
                if (!modelName) {
                    updateMachineStatus('Locked');
                    componentInput.disabled = true;
                    submitButton.disabled = true;
                    componentInput.placeholder = 'Pilih model terlebih dahulu';
                    return;
                }

                try {
                    const response = await fetch(`/api/model-items/${encodeURIComponent(modelName)}`);
                    if (!response.ok) {
                        throw new Error(`Gagal mengambil item model (${response.status})`);
                    }

                    const items = await response.json();

                    if (items.length > 0) {
                        itemsTbody.innerHTML = '';
                        scannedItems = {};
                        totalItems = items.length;
                        componentInput.disabled = false;
                        submitButton.disabled = false;
                        componentInput.placeholder = 'Scan Spareparts Here...';
                        updateMachineStatus('Locked');

                        items.forEach(item => {
                            const row = document.createElement('tr');
                            row.id = `item-row-${item.id}`;
                            row.style.cssText = 'border-bottom: 1px solid rgba(255, 255, 255, .08);';

                            const itemCell = document.createElement('td');
                            itemCell.style.cssText =
                                'padding: 1rem; text-align: left; font-size: .82rem;';
                            itemCell.textContent = item.item_name;

                            const statusCell = document.createElement('td');
                            statusCell.style.cssText =
                                'padding: 1rem; text-align: left; font-size: .82rem;';
                            statusCell.id = `status-${item.id}`;
                            statusCell.innerHTML = '<span style="color: #aaa;">Pending</span>';

                            row.appendChild(itemCell);
                            row.appendChild(statusCell);
                            itemsTbody.appendChild(row);

                            scannedItems[item.id] = {
                                item_name: item.item_name,
                                status: 'Pending'
                            };
                        });

                        itemsTableContainer.style.display = 'block';
                        updateProgress();
                        componentInput.focus();
                    } else {
                        updateMachineStatus('Locked');
                        componentInput.disabled = true;
                        submitButton.disabled = true;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Model Tidak Ditemukan',
                            text: `Tidak ada item untuk model "${modelName}"`,
                            confirmButtonColor: '#1677d2',
                            confirmButtonText: 'OK'
                        });
                        itemsTableContainer.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error fetching items:', error);
                    updateMachineStatus('Locked');
                    componentInput.disabled = true;
                    submitButton.disabled = true;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data item',
                        confirmButtonColor: '#1677d2',
                        confirmButtonText: 'OK'
                    });
                }
            }

            modelInput.addEventListener('change', () => {
                loadModelItems(modelInput.value);
            });

            // Handle scanning validation

            scanForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent form submission to server

                const scannedValue = componentInput.value.trim();

                if (!scannedValue || componentInput.disabled) {
                    return;
                }

                const scannedValueUpper = scannedValue.toUpperCase();
                let matched = false;

                // Allow retry: a failed attempt should not permanently lock an item.
                for (const [itemId, itemData] of Object.entries(scannedItems)) {
                    if (itemData.status === 'Success') {
                        continue;
                    }

                    if (itemData.item_name.toUpperCase() === scannedValueUpper) {
                        matched = true;
                        const statusCell = document.getElementById(`status-${itemId}`);
                        if (statusCell) {
                            statusCell.innerHTML =
                                '<span style="color: #18794e; font-weight: 700;">✓ Success</span>';
                            itemData.status = 'Success';
                        }

                        const modelName = document.getElementById('model_name').value;
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: `Komponen ${scannedValue} berhasil divalidasi untuk model ${modelName}.`,
                            confirmButtonColor: '#1677d2',
                            confirmButtonText: 'OK'
                        });
                        break;
                    }
                }

                if (!matched && Object.keys(scannedItems).length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: `Komponen ${scannedValue} tidak sesuai dengan daftar komponen yang diperlukan. Anda bisa scan ulang.`,
                        confirmButtonColor: '#1677d2',
                        confirmButtonText: 'OK'
                    });
                }

                const successCount = Object.values(scannedItems).filter(item => item.status === 'Success')
                    .length;
                const allCompleted = Object.keys(scannedItems).length > 0 && successCount === totalItems;

                if (allCompleted) {
                    componentInput.disabled = true;
                    submitButton.disabled = true;
                    componentInput.placeholder = 'Semua komponen sesuai';
                    updateMachineStatus('Running');
                } else {
                    updateMachineStatus('Locked');
                }

                updateProgress();
                componentInput.value = '';
                componentInput.focus();
            });

        </script>
</x-app-layout>
