<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(10);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolios.create');
    }

    public function store(StorePortfolioRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->uploadImage($request->file('image'));

        Portfolio::create($data);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                File::delete(public_path('uploads/portfolios/'.$portfolio->image));
            }
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        $portfolio->update($data);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->image) {
            File::delete(public_path('uploads/portfolios/'.$portfolio->image));
        }
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil dihapus.');
    }

    private function uploadImage($file)
    {
        $fileName = time().'_'.$file->getClientOriginalName();
        $destinationPath = public_path('uploads/portfolios');
        $file->move($destinationPath, $fileName);

        return $fileName;
    }
}
