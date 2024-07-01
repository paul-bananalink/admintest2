<?php

namespace App\Services\Sports;

use App\Repositories\TbFixtureRepository;
use App\Services\BaseService;
use App\Repositories\TbLeagueRepository;
use App\Repositories\TbTeamRepository;
use App\Repositories\TbParentRepository;

class SportService extends BaseService
{
    public function __construct(
        private TbLeagueRepository $tbLeagueRepository,
        private TbTeamRepository $tbTeamRepository,
        private TbParentRepository $tbParentRepository,
        private TbFixtureRepository $tbFixtureRepository
    ) {
    }

    public function getDataByType(string $type)
    {
        if ($type === 'league') {

            if (request('show') !== null) $conditions['where'][] = ['show', request('show')];
            if (request('search_input')) $conditions['where'][] = ['name', 'like', '%' . request('search_input') . '%'];

            $repo = $this->tbLeagueRepository;
        } elseif ($type === 'team') {

            if (request('search_input')) {
                $conditions['where'][] = ['team_name', 'like', '%' . request('search_input') . '%'];
                $conditions['orWhere'][] = ['team_name_kor', 'like', '%' . request('search_input') . '%'];
            }

            $repo = $this->tbTeamRepository;
        } elseif ($type === 'sport') {
            $repo = $this->tbFixtureRepository;

            if (request('search_input')) {
                $conditions['where'][] = ['home_team', 'like', '%' . request('search_input') . '%'];
                $conditions['orWhere'][] = ['away_team', 'like', '%' . request('search_input') . '%'];
            }
        } elseif ($type === 'realtime') {

            $repo = $this->tbFixtureRepository;

            if (request('search_input')) {
                $conditions['where'][] = ['home_team', 'like', '%' . request('search_input') . '%'];
                $conditions['orWhere'][] = ['away_team', 'like', '%' . request('search_input') . '%'];
            }
        }

        if (empty($repo)) {
            return [];
        }

        return $repo->paginateWithConditions(request()->get('page', 1), request()->get('per_page', 30), $sort ?? [], $conditions ?? []);
    }

    public function toggleShow(string $type, int $idx): bool
    {
        if ($type === 'league') {
            $res = $this->tbLeagueRepository->getByPK($idx);
        }

        if (empty($res)) {
            return false;
        }

        $data = [];
        $data['show'] = data_get($res, 'show') ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($res, $data) {
            $this->tbLeagueRepository->updateByPK($res, $data);
        });
    }

    public function updateTable(string $type, array $data)
    {
        return $this->tryCatchFuncDB(function () use ($type, $data) {

            if ($type === 'league') {
                foreach (data_get($data, 'idx') as $index => $id) {
                    $this->tbLeagueRepository->updateByPK($id, [
                        'name' => data_get($data, 'name')[$index],
                        'mark' => data_get($data, 'mark')[$index],
                    ]);
                }
            }

            if ($type === 'team') {
                foreach (data_get($data, 'idx') as $index => $id) {
                    $this->tbTeamRepository->updateByPK($id, [
                        'team_name' => data_get($data, 'team_name')[$index],
                        'team_name_kor' => data_get($data, 'team_name_kor')[$index],
                        'team_logo' => data_get($data, 'team_logo')[$index],
                    ]);
                }
            }
        });
    }

    public function updateRowTableTeam(int $idx, array $data): bool
    {
        $res = $this->tbTeamRepository->getByPK($idx);

        if (empty($res) || empty($data)) {
            return false;
        }

        return $this->tryCatchFuncDB(function () use ($res, $data) {
            $this->tbTeamRepository->updateByPK($res, [
                'team_name_kor' => data_get($data, 'team_name_kor'),
                'team_logo' => data_get($data, 'team_logo'),
            ]);
        });
    }
}
