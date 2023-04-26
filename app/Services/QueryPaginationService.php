<?php

namespace App\Services;

class QueryPaginationService
{
    public function getData($query, $request): array
    {
        if($category_id = $request->input('category_id')) $query->where('category_id', $category_id);

        if($s = $request->input('search')) $query->whereRaw("name LIKE '%" . $s . "%'");

        if($sort = $request->input('sort')) $query->orderBy('id', $sort);
        else $query->latest();

        $perPage = 20;
        if($pageSize = $request->input('page_size')) $perPage = $pageSize;

        $page = $request->input('page', 1);
        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'data' => $result,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage
        ];
    }
}
