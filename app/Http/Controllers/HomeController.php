<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $dbs = DB::select("SELECT * FROM pg_database;");
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        $views = DB::select("SELECT * FROM INFORMATION_SCHEMA.VIEWS WHERE table_schema = 'public'");
        $indexes = DB::select("SELECT * FROM pg_indexes WHERE tablename NOT LIKE 'pg%';");
        $primary = DB::select("SELECT * FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE constraint_type='PRIMARY KEY'");
        $foreign = DB::select("SELECT * FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE constraint_type='FOREIGN KEY'");
        $triggers = DB::select('SELECT * FROM INFORMATION_SCHEMA.triggers');
        $sequences = DB::select('SELECT * FROM INFORMATION_SCHEMA.SEQUENCES');
        $procedures = DB::select("SELECT  * FROM pg_catalog.pg_namespace n JOIN pg_catalog.pg_proc p ON p.pronamespace = n.oid WHERE n.nspname = 'public';");

        $data = [
            'quant_dbs' => count($dbs),
            'dbs' => $dbs,

            'quant_tables' => count($tables),
            'tables' => $tables,
            
            'quant_views' => count($views),
            'views' => $views,

            'quant_indexes' => count($indexes),
            'indexes' => $indexes,

            'quant_constraints' => count($primary) + count($foreign),
            'primary' => $primary,
            'foreign' => $foreign,
            
            'quant_triggers' => count($triggers),
            'triggers' => $triggers,
            
            'quant_sequences' => count($sequences),
            'sequences' => $sequences,

            'quant_procedures' => count($procedures),
            'procedures' => $procedures
            
        ];

        return view('home', $data);
    }

    public function sql_console(){
        return view('console');
    }

    public function post_create_database(Request $request){
        $request->validate([
            'db_name' => 'required'
        ]);
        DB::unprepared("CREATE DATABASE " . $request->input('db_name'));
        return redirect(route('home'));
    }
    public function post_delete_database(Request $request){
        DB::unprepared("DROP DATABASE " . $request->input('db_name'));
        return redirect(route('home'));
    }

    public function post_sql_console(Request $request){
        $request->validate([
            'sql_query' => 'required'
        ]);

        try {
            $query_response = DB::select(DB::raw($request->input('sql_query')));
            return $query_response;
            // return view('sql_console', ['query_response', $query_response ]);

        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('sql_console');
        }

    }


    // TABLES
    public function create_table(){
        return view('create_table');
    }
    public function post_create_table(Request $request){
        $request->validate([
            'table_name' => 'required',
            'array_fields' => 'required',
            'array_types' => 'required'
        ]);

        $table_name = $request->input('table_name');
        $fields = explode(",", $request->input('array_fields'));
        $types = explode(",", $request->input('array_types'));

        $sql = 'CREATE TABLE ' . $table_name . '(';

        for ($i=0; $i < count($fields); $i++) {
            if($i != count($fields)-1){
                $sql.= $fields[$i].' '.$types[$i] . ', ';
            }else {
                $sql .= $fields[$i] . ' ' . $types[$i] . ');';
            }
        }

        DB::select(DB::raw($sql));

        return redirect(route('home'));
    }
    public function edit_table($name){
        $cols = DB::getSchemaBuilder()->getColumnListing($name);

        return view('edit_table', ['name' => $name, 'cols' => $cols]);
    }
    public function post_edit_table(Request $request){
        $request->validate([
            'old_table_name' => 'required',
            'table_name' => 'required',
            'new_cols' => 'required',
            'new_types' => 'required',
        ]);

        $old = $request->input('old_table_name');
        $table_name = $request->input('table_name');
        $new_cols = explode(",", $request->input('new_cols'));
        $new_types = explode(",", $request->input('new_types'));

        Schema::dropIfExists($old);

        $sql = 'CREATE TABLE ' . $table_name . '(';

        for ($i = 0; $i < count($new_cols); $i++) {
            if ($i != count($new_cols) - 1) {
                $sql .= $new_cols[$i] . ' ' . $new_types[$i] . ', ';
            } else {
                $sql .= $new_cols[$i] . ' ' . $new_types[$i] . ');';
            }
        }

        DB::select(DB::raw($sql));

        return redirect(route('home'));
    }
    public function post_delete_table(Request $request){
        $request->validate([
            'table_name' => 'required'
        ]);

        $sql = 'DROP TABLE ' . $request->input('table_name') . ';';

        DB::select($sql);
        return redirect(route('home'));
    }



    // VIEWS
    public function create_view(){
        return view('create_view');
    }
    public function edit_view($name){
        $view = DB::select("SELECT * FROM INFORMATION_SCHEMA.VIEWS WHERE table_name = '" . $name . "'");

        return view('edit_view', [
            'view' => $view
        ]);
    }
    public function post_create_view(Request $request){
        $request->validate([
            'view_name' => 'required',
            'view_query' => 'required'
        ]);

        try {
            DB::unprepared("CREATE VIEW " . $request->input('view_name') . " AS " . $request->input('view_query'));
            session()->flash('new_view', 'Vista Creada Exitosamente!');
            return redirect()->route('home');
        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_view');
        }
    }
    public function post_edit_view(Request $request){
        $request->validate([
            'old_view_name' => 'required',
            'new_view_query' => 'required'
        ]);
        DB::unprepared('DROP VIEW ' . $request->input('old_view_name') . ';');
        DB::unprepared('CREATE VIEW ' . $request->input('new_view_name') . ' AS '. $request->input('new_view_query') .';');
        return redirect(route('home'));
    }
    public function post_delete_view(Request $request){
        $request->validate([
            'view_name' => 'required'
        ]);

        DB::unprepared('DROP VIEW IF EXISTS ' . $request->input('view_name') . ';');
        return redirect(route('home'));
    }



    // INDEX
    public function create_index(){
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        return view('create_index', ['table' => $tables]);
    }
    public function edit_index($name){
        $index = DB::select("SELECT * FROM pg_indexes WHERE indexname='" . $name . "';");
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        return view('edit_index', [
            'index' => $index,
            'table' => $tables
        ]);
    }
    public function post_create_index(Request $request){
        $request->validate([
            'index_name' => 'required',
            'index_table' => 'required',
            'index_fields' => 'required'
        ]);

        try {            
            $query = "CREATE INDEX " . $request->input('index_name') . " ON " . $request->input('index_table') . " (" . $request->input('index_fields') . ");";
            DB::unprepared($query);

            session()->flash('new_index', 'Index Creado Exitosamente!');
            return redirect()->route('home');

        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_index');
        }
    }
    public function post_edit_index(Request $request){
        $request->validate([
            'old_index_name' => 'required',
            'index_name' => 'required',
            'table_index' => 'required',
            'index_fields' => 'required' 
        ]);

        DB::unprepared("DROP INDEX " . $request->input('old_index_name') . ';');
        $query = "CREATE INDEX " . $request->input('index_name') . " ON " . $request->input('table_index') . " (" . $request->input('index_fields') . ");";
        DB::unprepared($query);
        return redirect(route('home'));
    }
    public function post_delete_index(Request $request){
        $request->validate([
            'index_name' => 'required',
            'index_table' => 'required',
        ]);
        
        DB::unprepared("DROP INDEX " . $request->input('index_name') . ';');
        return redirect(route('home'));
    }


    // CONSTRAINT
    public function create_constraint(){
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        return view('create_constraint', ['table' => $tables]);
    }
    public function edit_constraint($name){
        $constraint = DB::select("SELECT * FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE constraint_name='" . $name . "';");
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        return view('edit_constraint', [
            'constraint' => $constraint,
            'table' => $tables
        ]);
    }
    public function post_primary_key(Request $request){
        $request->validate([
            'constraint_table' =>'required',
            'constraint_field' => 'required'
        ]);

        try {
            DB::unprepared("ALTER TABLE " . $request->input('constraint_table') . " ADD PRIMARY KEY (" . $request->input('constraint_field') .  ");");

            session()->flash('new_primary', 'Llave primaria asignada exitosamente!');
            return redirect()->route('home');

        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_constraint');
        }
    }
    public function post_foreign_key(Request $request){
        $request->validate([
            'table_foreign' => 'required',
            'foreign_key' => 'required',
            'ref_table' =>'required',
            'ref_id' => 'required'
        ]);

        try {
            $table_foreign = $request->input('table_foreign');
            $foreign_key = $request->input('foreign_key');
            $ref_table = $request->input('ref_table');
            $ref_id = $request->input('ref_id');

            DB::unprepared("ALTER TABLE " . $table_foreign . " ADD FOREIGN KEY (" . $foreign_key .  ") REFERENCES " . $ref_table .  "(" . $ref_id .");");

            session()->flash('new_foreign', 'Llave foranea asignada exitosamente!');
            return redirect()->route('home');
        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_constraint');
        }
    }
    public function post_edit_primary(Request $request){
        $request->validate([
            'primary_name'=>'required',
        ]);

        DB::unprepared("ALTER TABLE " . $request->input('primary_table') . " DROP CONSTRAINT " . $request->input('primary_name') . ";");
        DB::unprepared("ALTER TABLE " . $request->input('primary_table') . " ADD PRIMARY KEY (" . $request->input('primary_key') .  ");");
        return redirect(route('home'));
    }
    public function post_edit_foreign(Request $request){
        $request->validate([
            'foreign_name' => 'required',
            'foreign_table' => 'required',
            'foreign_key' => 'required',
            'ref_table' => 'required',
            'ref_field' => 'required',
        ]);

        DB::unprepared("ALTER TABLE " . $request->input('foreign_table') . " DROP CONSTRAINT " . $request->input('foreign_name') . ";");
        DB::unprepared("ALTER TABLE " . $request->input('foreign_table') . " ADD FOREIGN KEY (" . $request->input('foreign_key') .  ") REFERENCES " . $request->input('ref_table') .  "(" . $request->input('ref_field') . ");");

        return redirect(route('home'));
    }
    public function post_delete_primary_key(Request $request){
        $request->validate([
            'primary_table' => 'required',
            'primary_name' => 'required'
        ]);

        try {
            DB::unprepared("ALTER TABLE " . $request->input('primary_table') . " DROP CONSTRAINT " . $request->input('primary_name') . ';');
            
        } catch (\Throwable $th) {
            return $th;
        }

        return redirect(route('home'));
    }
    public function post_delete_foreign_key(Request $request){
        $request->validate([
            'foreign_table' => 'required',
            'foreign_name' => 'required'
        ]);

        try {
            DB::unprepared("ALTER TABLE " . $request->input('foreign_table') . " DROP CONSTRAINT " . $request->input('foreign_name') . ';');
        } catch (\Throwable $th) {
            return $th;
        }

        return redirect(route('home'));
    }


    // TRIGGER
    public function create_trigger(){
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        return view('create_trigger', ['table' => $tables]);
    }
    public function edit_trigger(){
        return view('edit_trigger');
    }
    public function post_create_trigger(Request $request){
        $request->validate([
            'trigger_name' => 'required',
            'trigger_table' => 'required',
            'trigger_time' => 'required',
            'trigger_event' => 'required',
            'trigger_query' => 'required'
        ]);

        try {
            DB::unprepared("CREATE TRIGGER " . $request->input('trigger_name'). ' ' . $request->input('trigger_time') . " " . $request->input('trigger_event') . " ON "
                . $request->input('trigger_table') . " FOR EACH ROW ");
                session()->flash('new_trigger', 'Trigger creado exitosamente!.');

        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex);
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_trigger');
        }

    }


    // SEQUENCES
    public function create_sequence(){
        return view('create_sequence');
    }
    public function edit_sequence($name){
        $sequence = DB::select("SELECT * FROM INFORMATION_SCHEMA.SEQUENCES WHERE sequence_name ='" . $name . "';");

        return view('edit_sequence', [
            'sequence' => $sequence
        ]);
    }
    public function post_create_sequence(Request $request){
        $request->validate([
            'sequence_name' => 'required',
            'sequence_query' => 'required',
        ]);

        try {
            DB::unprepared("CREATE SEQUENCE " . $request->input('sequence_name') . " " . $request->input('sequence_query') );
            
            session()->flash('new_sequence', 'Secuencia creada exitosamente!.');
            return redirect()->route('home');

         } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_sequence');
        }
    }
    public function post_edit_sequence(Request $request){
        $request->validate([
            'old_sequence_name'=>'required',
            'sequence_name' => 'required',
            'sequence_query' => 'required',
        ]);

        DB::unprepared("ALTER SEQUENCE " . $request->input('old_sequence_name') . " " . $request->input('sequence_query'));
        DB::unprepared("ALTER SEQUENCE " . $request->input('old_sequence_name') . " RENAME TO " . $request->input('sequence_name'));
        return redirect(route('home'));
    }
    public function post_delete_sequence(Request $request){
        $request->validate([
            'sequence_name'=>'required'
        ]);

        try {
            DB::unprepared('DROP SEQUENCE ' . $request->input('sequence_name'));
        } catch (\Throwable $th) {
            return $th;
        }

        return redirect(route('home'));
    }


    // PROCEDURES
    public function create_procedure(){
        return view('create_procedure');
    }
    public function edit_procedure($name){
        $procedure = DB::select("SELECT  * FROM pg_catalog.pg_namespace n JOIN pg_catalog.pg_proc p ON p.pronamespace = n.oid WHERE n.nspname = 'public' AND proname='". $name ."';");
        return view('edit_procedure', [
            'procedure' => $procedure
        ]);
    }
    public function post_create_procedure(Request $request){
        $request->validate([
            'procedure_name' => 'required',
            'procedure_query' => 'required',
        ]);

        $sql = "CREATE OR REPLACE FUNCTION " . $request->input('procedure_name') . "()" . $request->input('procedure_query');

        try {
            DB::unprepared($sql);
            session()->flash('new_procedure', 'Funcion Creada Exitosamente!');
            return redirect(route('home'));
        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_procedure');
        }
    }
    public function post_edit_procedure(Request $request){
        $sql = "CREATE OR REPLACE FUNCTION " . $request->input('procedure_name') . "()" . $request->input('procedure_query');

        try {
            DB::unprepared("DROP FUNCTION " . $request->input('old_procedure_name') . "();");
            DB::unprepared($sql);
            return redirect(route('home'));
        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('query_error', 'Error no se pudo Procesar su Query.');
            return redirect()->route('create_procedure');
        }        
    }
    public function post_delete_procedure(Request $request){
        DB::unprepared('DROP FUNCTION ' . $request->input('procedure_name') . '();');
        return redirect(route('home'));
    }
}
