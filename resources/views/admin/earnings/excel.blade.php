@php
    $totalApp = $appProjects->sum('app_price');
    $totalWriter = $writerProjects->sum('writer_price');

    $unpaidApp = $appProjects->where('is_programmer_paid', false)->sum('app_price');
    $unpaidWriter = $writerProjects->where('is_writer_paid', false)->sum('writer_price');

    $totalUmum = 0;
    $unpaidUmum = 0;
    $corporateData = [];

    if (isset($umumProjects) && $umumProjects->count() > 0) {
        foreach ($umumProjects as $project) {
            $team = is_string($project->custom_team) ? json_decode($project->custom_team, true) : $project->custom_team;
            $myFee = 0;
            $isPaid = false;
            $myRole = 'Developer';

            if (is_array($team)) {
                foreach ($team as $member) {
                    if (isset($member['user_id']) && $member['user_id'] == auth()->id()) {
                        $myFee = (float) ($member['fee'] ?? 0);
                        $isPaid = $member['is_paid'] ?? false;
                        $myRole = $member['role'] ?? 'Developer';

                        $totalUmum += $myFee;
                        if (!$isPaid) {
                            $unpaidUmum += $myFee;
                        }
                        break;
                    }
                }
            }

            $corporateData[] = (object) [
                'client_name' => $project->client_name,
                'role' => $myRole,
                'status' => $project->status,
                'is_paid' => $isPaid,
                'fee' => $myFee,
            ];
        }
    }

    $grandTotal = $totalApp + $totalWriter + $totalUmum;
    $totalUnpaid = $unpaidApp + $unpaidWriter + $unpaidUmum;
@endphp

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
        <td colspan="3">{{ $periode ?? 'Semua' }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <tr>
        <td colspan="5" style="background-color: #3b82f6; color: #ffffff; font-weight: bold;">A. PENDAPATAN SEBAGAI
            DEVELOPER APLIKASI (MAHASISWA)</td>
    </tr>
    <tr>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">No</td>
        <td style="background-color: #f1f5f9; font-weight: bold;">Nama Klien</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Proyek</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Pencairan Fee</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: right;">Nominal (Rp)</td>
    </tr>
    @if ($appProjects->count() > 0)
        @foreach ($appProjects as $idx => $project)
            <tr>
                <td style="text-align: center;">{{ $idx + 1 }}</td>
                <td>{{ $project->client_name }}</td>
                <td style="text-align: center;">{{ $project->status }}</td>
                <td style="text-align: center;">{{ $project->is_programmer_paid ? 'SUDAH CAIR' : 'BELUM CAIR' }}</td>
                <td style="text-align: right;">{{ $project->app_price }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" style="text-align: center; color: #64748b;">Tidak ada data proyek aplikasi mahasiswa.
            </td>
        </tr>
    @endif
    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; background-color: #e2e8f0;">SUBTOTAL APLIKASI
        </td>
        <td style="text-align: right; font-weight: bold; background-color: #e2e8f0;">{{ $totalApp }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <tr>
        <td colspan="5" style="background-color: #f59e0b; color: #ffffff; font-weight: bold;">B. PENDAPATAN SEBAGAI
            PENYUSUN NASKAH</td>
    </tr>
    <tr>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">No</td>
        <td style="background-color: #f1f5f9; font-weight: bold;">Nama Klien</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Proyek</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Pencairan Fee</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: right;">Nominal (Rp)</td>
    </tr>
    @if ($writerProjects->count() > 0)
        @foreach ($writerProjects as $idx => $project)
            <tr>
                <td style="text-align: center;">{{ $idx + 1 }}</td>
                <td>{{ $project->client_name }}</td>
                <td style="text-align: center;">{{ $project->status }}</td>
                <td style="text-align: center;">{{ $project->is_writer_paid ? 'SUDAH CAIR' : 'BELUM CAIR' }}</td>
                <td style="text-align: right;">{{ $project->writer_price }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" style="text-align: center; color: #64748b;">Tidak ada data proyek naskah.</td>
        </tr>
    @endif
    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; background-color: #fef3c7;">SUBTOTAL NASKAH</td>
        <td style="text-align: right; font-weight: bold; background-color: #fef3c7;">{{ $totalWriter }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <tr>
        <td colspan="5" style="background-color: #1E293B; color: #ffffff; font-weight: bold;">C. PENDAPATAN SEBAGAI
            DEVELOPER CORPORATE</td>
    </tr>
    <tr>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">No</td>
        <td style="background-color: #f1f5f9; font-weight: bold;">Nama Klien dan Role</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Proyek</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: center;">Status Pencairan Fee</td>
        <td style="background-color: #f1f5f9; font-weight: bold; text-align: right;">Nominal (Rp)</td>
    </tr>
    @if (count($corporateData) > 0)
        @foreach ($corporateData as $idx => $corp)
            <tr>
                <td style="text-align: center;">{{ $idx + 1 }}</td>
                <td>{{ $corp->client_name }} (Role: {{ $corp->role }})</td>
                <td style="text-align: center;">{{ $corp->status }}</td>
                <td style="text-align: center;">{{ $corp->is_paid ? 'SUDAH CAIR' : 'BELUM CAIR' }}</td>
                <td style="text-align: right;">{{ $corp->fee }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" style="text-align: center; color: #64748b;">Tidak ada data proyek corporate.</td>
        </tr>
    @endif
    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; background-color: #e2e8f0;">SUBTOTAL CORPORATE
        </td>
        <td style="text-align: right; font-weight: bold; background-color: #e2e8f0;">{{ $totalUmum }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <tr>
        <td colspan="4" style="font-weight: bold; background-color: #f8fafc;">TOTAL KESELURUHAN (Termasuk belum
            selesai)</td>
        <td style="text-align: right; font-weight: bold; background-color: #f8fafc;">{{ $grandTotal }}</td>
    </tr>
    <tr>
        <td colspan="4" style="font-weight: bold; color: #b91c1c; background-color: #fee2e2;">TOTAL SISA PIUTANG
            (Belum Ditransfer ke Rekening)</td>
        <td style="text-align: right; font-weight: bold; color: #b91c1c; background-color: #fee2e2;">
            {{ $totalUnpaid }}</td>
    </tr>
</table>
