<?php
namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Db\Adapter\AdapterInterface;
use App\Model\Aluno;
use Zend\Diactoros\Response\RedirectResponse;

class AlunoAction
{
    
    private $dbAdapter;
    
    private $router;

    private $template;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, $dbAdapter)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->dbAdapter  = $dbAdapter; 
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $data = [];
        Aluno::setDbAdapter($this->dbAdapter);
        $path = $request->getUri()->getPath();
        $path = explode('/', $path);
        if (isset($path[3])) {
            // remove a matrícula       
            unset($path[3]);
        }
        $path = implode('/', $path);
        
        switch ($path) {
            case '/aluno/save':
                $matricula = isset($_POST['matricula']) ? $_POST['matricula'] : null;
                $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
                $aluno = new Aluno([
                    'matricula' => $matricula,
                    'nome' => $nome
                ]);
                $aluno->save();
                return new RedirectResponse($this->router->generateUri('list'));
            case '/alunos':
                $page = 'alunos';
                $data['editLink'] = $this->router->generateUri('edit');
                $data['deleteLink'] = $this->router->generateUri('delete');
                $data['alunos'] = Aluno::getAll();
                break;
            case '/aluno/edit':
                $page = 'edit';
                $matricula = $request->getAttribute('matricula', null);
                if (is_null($matricula)) {
                    $aluno = ['matricula'=>null,'nome'=>null];
                } else {
                    $aluno = Aluno::get($matricula);
                }
                $data['aluno'] = $aluno;
                $data['saveLink'] = $this->router->generateUri('save');
                $data['returnLink'] = $this->router->generateUri('list');
                break;
            case '/aluno/delete':
                $matricula = $request->getAttribute('matricula', null);
                Aluno::delete($matricula);
                return new RedirectResponse($this->router->generateUri('list'));
                
            default:
                $page = 'home-page';
            }
        $content = $this->template->render('app::' . $page, $data);
        $output = $this->template->render('layout::default');
        $output = str_replace('$content', $content, $output);
        return new HtmlResponse($output);
    }
    
}

?>