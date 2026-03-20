<table>
    <tr>
        <td colspan="5" style="text-align: center; font-weight: bold; font-size: 14px;">REKAP PENDAPATAN TIM -
            KARYANTARA SOLUTION</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Nama Tim:</strong></td>
        <td colspan="3">{{ auth()->user()->name }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Periode:</strong></td>
        <td colspan="3">{{ $periode }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <tr>
        <td colspan="5" style="background-color: #3b82f6; color: #ffffff; font-weight: bold;">A. PENDAPATAN SEBAGAI
            DEVELOPER APLIKASI</td>
    </tr>
    <tr>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: center;">No</th>
        <th style="background-color: #f1f5f9; font-weight: bold;">Nama Klien</th>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Proyek</th>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Pencairan Fee</th>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: right;">Nominal (Rp)</th>
    </tr>
    @forelse($appProjects as $idx => $project)
        <tr>
            <td style="text-align: center;">{{ $idx + 1 }}</td>
            <td>{{ $project->client_name }}</td>
            <td style="text-align: center;">{{ $project->status }}</td>
            <td style="text-align: center;">{{ $project->is_programmer_paid ? 'SUDAH CAIR' : 'BELUM CAIR' }}</td>
            <td style="text-align: right;">{{ $project->app_price }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align: center; color: #64748b;">Tidak ada data proyek aplikasi di periode
                ini.</td>
        </tr>
    @endforelse
    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; background-color: #e2e8f0;">SUBTOTAL APLIKASI
        </td>
        <td style="text-align: right; font-weight: bold; background-color: #e2e8f0;">
            {{ $appProjects->sum('app_price') }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <tr>
        <td colspan="5" style="background-color: #f59e0b; color: #ffffff; font-weight: bold;">B. PENDAPATAN SEBAGAI
            PENYUSUN NASKAH</td>
    </tr>
    <tr>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: center;">No</th>
        <th style="background-color: #f1f5f9; font-weight: bold;">Nama Klien</th>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Proyek</th>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Pencairan Fee</th>
        <th style="background-color: #f1f5f9; font-weight: bold; text-align: right;">Nominal (Rp)</th>
    </tr>
    @forelse($writerProjects as $idx => $project)
        <tr>
            <td style="text-align: center;">{{ $idx + 1 }}</td>
            <td>{{ $project->client_name }}</td>
            <td style="text-align: center;">{{ $project->status }}</td>
            <td style="text-align: center;">{{ $project->is_writer_paid ? 'SUDAH CAIR' : 'BELUM CAIR' }}</td>
            <td style="text-align: right;">{{ $project->writer_price }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align: center; color: #64748b;">Tidak ada data proyek naskah di periode ini.
            </td>
        </tr>
    @endforelse
    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; background-color: #fef3c7;">SUBTOTAL NASKAH</td>
        <td style="text-align: right; font-weight: bold; background-color: #fef3c7;">
            {{ $writerProjects->sum('writer_price') }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    @php
        $totalApp = $appProjects->sum('app_price');
        $totalWriter = $writerProjects->sum('writer_price');
        $grandTotal = $totalApp + $totalWriter;

        $unpaidApp = $appProjects->where('is_programmer_paid', false)->sum('app_price');
        $unpaidWriter = $writerProjects->where('is_writer_paid', false)->sum('writer_price');
        $totalUnpaid = $unpaidApp + $unpaidWriter;
    @endphp
    <tr>
        <td colspan="4" style="font-weight: bold;">TOTAL KESELURUHAN (Termasuk belum selesai)</td>
        <td style="text-align: right; font-weight: bold;">{{ $grandTotal }}</td>
    </tr>
    <tr>
        <td colspan="4" style="font-weight: bold; color: #b91c1c;">TOTAL SISA PIUTANG (Belum Ditransfer ke Rekening)
        </td>
        <td style="text-align: right; font-weight: bold; color: #b91c1c;">{{ $totalUnpaid }}</td>
    </tr>
</table>
