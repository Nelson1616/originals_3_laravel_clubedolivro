<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function index()
    {
        try
        {
            $books = $this->book->all();
            return response()->json(['data' => $books], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }      
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try
        {
            $book = $this->book->create($data);
            return response()->json(['data' => ['msg' => 'Livro cadastrado com sucesso!']], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        try
        {
            $book = $this->book->find($id);
            if(!$book)
            {
                return response()->json(['data' => ['msg' => 'Livro não encontrado']]);
            }
            $book->update($data);
            return response()->json(['data' => ['msg' => 'Livro atualizado com sucesso!']], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }

    public function destroy($id)
    {
        try
        {
            $book = $this->book->find($id);
            if(!$book)
            {
                return response()->json(['data' => ['msg' => 'Livro não encontrado']]);
            }
            $book->delete();
            return response()->json(['data' => ['msg' => 'Livro apagado com sucesso!']], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }

    public function show($id)
    {
        try
        {
            $book = $this->book->find($id);
            if(!$book)
            {
                return response()->json(['data' => ['msg' => 'Livro não encontrado']]);
            }
            $book->user;
            foreach($book->lends as $lend)
            {
                $lend->user;
            }
            return response()->json(['data' => $book], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }
}
