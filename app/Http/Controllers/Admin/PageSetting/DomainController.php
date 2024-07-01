<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DomainRequest;
use App\Services\DomainService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
  private $domainService;

    public function __construct(DomainService $domainService)
    {
        $this->domainService = $domainService;
    }
  public function index()
  {
    $data = $this->domainService->getAllDomains()->sortByDesc('dRegDate');
   
    return view('Admin.PageSetting.Domain.index_domain', compact('data'));
  }

  public function create(DomainRequest $request)
  {
      $data = $this->domainService->create($request->all());

      if ($data) {
        return redirect()->route('admin.page-setting.domain.indexDomain', $data)->with('success', '업데이트 성공');
    }
    return redirect()->route('admin.page-setting.domain.indexDomain', $data)->with('error', '업데이트 실패');
  }

  public function update(DomainRequest $request, int $id)
  {
      $domain = $this->domainService->getById($id);
      $data = $this->domainService->update($domain, $request->except(['dIsMain', 'dIsRefresh']));

      if ($data) {
        return redirect()->route('admin.page-setting.domain.indexDomain', $data)->with('success', '업데이트 성공');
    }
    return redirect()->route('admin.page-setting.domain.indexDomain', $data)->with('error', '업데이트 실패');
  }

  public function toggleField(string $field = '', int $id)
  {
      $status = $this->domainService->toggleField($id, $field);
      return response()->json(['status' => $status]);
  }

  public function delete(int $id)
  {
      $this->domainService->delete($id);

      return $this->responseData(['message' => '업데이트 성공.', 'type' => 'success'], 200);
  }

}
