<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Inventory - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Staff</span></div>
            <nav class="nav-links">
                <a href="{{ route('staff.dashboard') }}">My Dashboard</a>
                <a href="{{ route('staff.tasks') }}">My Tasks</a>
                <a href="{{ route('staff.scan') }}" class="active">Scan Inventory</a>
                <a href="{{ route('staff.report') }}">Report Issue</a>
            </nav>
            <div class="logout-section">
                <form method="post" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </aside>
        <main class="main-content">
            <header class="top-bar">
                <div class="page-title">
                    <h1>Scan Inventory</h1>
                    <p class="date">{{ now()->format('l, M j, Y') }}</p>
                </div>
                <div class="user-profile">
                    <div class="user-info">
                        <span>{{ Auth::user()->name }}</span>
                        <small>{{ Auth::user()->role }}</small>
                    </div>
                    <div class="avatar" style="background-color: #f1c40f;"></div>
                </div>
            </header>

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 20px;">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="stats-grid">
                <div class="card stat-card">
                    <h3>Queue (Last 15 mins)</h3>
                    <div class="number" id="queue-count">{{ $queueCount ?? 0 }}</div>
                    <div class="trend" id="queue-level">Checking...</div>
                </div>
            </div>

            <div class="recent-orders">
                <h2>Barcode / QR Scanner</h2>
                <p>Scan or type item code (ITM-001, barcode, invoice, receipt, sale code).</p>
                <div class="input-group" style="max-width: 680px; margin-top: 20px;">
                    <label for="scan-code">Scan / Type Code</label>
                    <input type="text" id="scan-code" name="scan_code" placeholder="Scan barcode or enter item code" autofocus>
                </div>

                <div style="display: flex; gap: 10px; margin: 10px 0 16px; flex-wrap: wrap;">
                    <button type="button" class="filter-btn" onclick="lookupCode()">Lookup</button>
                    <button type="button" class="filter-btn" onclick="startCameraScanner()">Start Camera Scanner</button>
                    <button type="button" class="filter-btn" onclick="stopCameraScanner()">Stop Scanner</button>
                </div>

                <video id="scanner-video" style="display:none; width: 100%; max-width: 520px; border-radius: 12px; margin-bottom: 12px;" autoplay playsinline muted></video>

                <div id="scan-result" class="card" style="display:none; margin-top: 10px;"></div>
            </div>

            <div class="recent-orders" style="margin-top: 18px;">
                <h2>Refund / Void</h2>
                <p>Type or scan item code. System auto-detects item and updates inventory + logs.</p>
                <form method="POST" action="{{ route('staff.refund') }}" style="display: grid; gap: 10px; max-width: 680px;">
                    @csrf
                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="refund_item_code">Item / Sale / Invoice / Receipt Code</label>
                        <input id="refund_item_code" type="text" name="item_code" required placeholder="ITM-001 or SL-... or INV-... or RCP-...">
                    </div>
                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="action_type">Action</label>
                        <select id="action_type" name="action_type" required>
                            <option value="refund">Refund</option>
                            <option value="void">Void</option>
                        </select>
                    </div>
                    <div class="input-group" style="margin-bottom: 0;" id="quantity-wrap">
                        <label for="refund_qty">Refund Quantity</label>
                        <input id="refund_qty" type="number" name="quantity" min="1" value="1">
                    </div>
                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="refund_reason">Reason</label>
                        <textarea id="refund_reason" name="reason" rows="2"></textarea>
                    </div>
                    <button class="btn-login" type="submit">Process Refund / Void</button>
                </form>
            </div>

            <div class="recent-orders" style="margin-top: 18px;">
                <h2>Live Stock Updates</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Item</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Change</th>
                            <th>After</th>
                        </tr>
                    </thead>
                    <tbody id="live-stock-body">
                        <tr>
                            <td colspan="6" style="text-align: center; color: #9bb7ed;">Loading live stock feed...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="recent-orders" style="margin-top: 18px;">
                <h2>Recent Spoilage Logs (For Complaint Checks)</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Detected</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSpoilageLogs as $log)
                            <tr>
                                <td>{{ optional($log->detected_at)->format('M d, h:i A') }}</td>
                                <td>{{ $log->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ $log->quantity }}</td>
                                <td>{{ strtoupper($log->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #9bb7ed;">No spoilage logs yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        let scannerStream = null;
        let scannerInterval = null;

        async function lookupCode(value = null) {
            const code = value ?? document.getElementById('scan-code').value.trim();
            if (!code) {
                return;
            }

            const target = document.getElementById('scan-result');
            target.style.display = 'block';
            target.innerHTML = 'Searching item...';

            try {
                const response = await fetch(`{{ route('staff.scan.lookup') }}?code=${encodeURIComponent(code)}`);
                const data = await response.json();

                if (!response.ok || !data.found) {
                    target.innerHTML = `<strong>Not found:</strong> ${data.message ?? 'Unknown item code.'}`;
                    return;
                }

                const item = data.item;
                const movement = data.latest_movement;

                target.innerHTML = `
                    <h3 style="margin-bottom: 8px;">${item.name}</h3>
                    <p><strong>Code:</strong> ${item.code} | <strong>Category:</strong> ${item.category ?? 'N/A'}</p>
                    <p><strong>Stock:</strong> ${item.stock} | <strong>Price:</strong> Php ${Number(item.price).toFixed(2)} | <strong>Status:</strong> ${item.status}</p>
                    <p><strong>Latest Movement:</strong> ${movement ? `${movement.type} (${movement.change}) at ${movement.at}` : 'No movement yet.'}</p>
                `;

                document.getElementById('refund_item_code').value = item.code;
            } catch (error) {
                target.innerHTML = 'Scanner lookup failed. Please try again.';
            }
        }

        async function refreshLiveSnapshot() {
            try {
                const response = await fetch('{{ route('staff.live.snapshot') }}');
                const data = await response.json();
                if (!response.ok) {
                    return;
                }

                const queueCount = Number(data.queue?.count ?? 0);
                const queueLevel = (data.queue?.level ?? 'low').toUpperCase();
                const queueLabel = document.getElementById('queue-level');
                document.getElementById('queue-count').textContent = queueCount;
                queueLabel.textContent = `Queue Level: ${queueLevel}`;
                queueLabel.className = `trend ${queueLevel === 'HIGH' ? 'down' : 'up'}`;

                const tbody = document.getElementById('live-stock-body');
                const items = data.recent_stock ?? [];
                if (!items.length) {
                    tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#9bb7ed;">No stock movement yet.</td></tr>';
                    return;
                }

                tbody.innerHTML = items.map((row) => `
                    <tr>
                        <td>${row.time}</td>
                        <td>${row.item}</td>
                        <td>${row.code}</td>
                        <td>${String(row.type).toUpperCase()}</td>
                        <td>${row.change}</td>
                        <td>${row.after}</td>
                    </tr>
                `).join('');
            } catch (_) {
                // Keep UI stable even when polling fails temporarily.
            }
        }

        async function startCameraScanner() {
            if (!('BarcodeDetector' in window)) {
                alert('Camera scanner is not supported on this browser. Use manual input instead.');
                return;
            }

            try {
                const video = document.getElementById('scanner-video');
                scannerStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                video.srcObject = scannerStream;
                video.style.display = 'block';

                const detector = new BarcodeDetector({ formats: ['qr_code', 'code_128', 'ean_13', 'ean_8', 'upc_a', 'upc_e'] });
                scannerInterval = setInterval(async () => {
                    if (!video.videoWidth) {
                        return;
                    }

                    const barcodes = await detector.detect(video);
                    if (!barcodes.length) {
                        return;
                    }

                    const code = barcodes[0].rawValue?.trim();
                    if (!code) {
                        return;
                    }

                    document.getElementById('scan-code').value = code;
                    lookupCode(code);
                }, 700);
            } catch (error) {
                alert('Unable to start camera scanner. Check camera permission.');
            }
        }

        function stopCameraScanner() {
            const video = document.getElementById('scanner-video');
            if (scannerInterval) {
                clearInterval(scannerInterval);
                scannerInterval = null;
            }
            if (scannerStream) {
                scannerStream.getTracks().forEach((track) => track.stop());
                scannerStream = null;
            }
            video.style.display = 'none';
            video.srcObject = null;
        }

        document.getElementById('scan-code').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                lookupCode();
            }
        });

        document.getElementById('action_type').addEventListener('change', function() {
            const isVoid = this.value === 'void';
            document.getElementById('quantity-wrap').style.display = isVoid ? 'none' : 'block';
            document.getElementById('refund_qty').required = !isVoid;
        });

        refreshLiveSnapshot();
        setInterval(refreshLiveSnapshot, 8000);
    </script>
</body>
</html>
