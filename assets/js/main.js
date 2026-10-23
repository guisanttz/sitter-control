// SitterControl - JavaScript Principal

// ================= TOAST =================
let toastTimer = null;
function showToast(mensagem, tipo = 'sucesso') {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toast-msg');
    if (!toast || !toastMsg) return;

    toastMsg.textContent = mensagem;

    const svgUse = toast.querySelector('use');
    if (svgUse) {
        if (tipo === 'erro') {
            svgUse.setAttribute('href', '#i-alert');
            svgUse.style.stroke = 'var(--danger)';
        } else {
            svgUse.setAttribute('href', '#i-check');
            svgUse.style.stroke = 'var(--primary)';
        }
    }

    toast.classList.add('show');

    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        toast.classList.remove('show');
    }, 4000);
}

// ================= CONTROLE DE MODAIS =================
function openModal(id) {
    const modal = document.getElementById(id.startsWith('modal-') ? id : 'modal-' + id);
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function fecharModal(id) {
    const modal = document.getElementById(id.startsWith('modal-') ? id : 'modal-' + id);
    if (modal) {
        modal.classList.add('hidden');
    }
}

function closeModal() {
    document.querySelectorAll('.modal-overlay').forEach(m => m.classList.add('hidden'));
}

// Fechar modais ao clicar no fundo escuro
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.add('hidden');
    }
});

// Fechar modal com tecla ESC
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// ================= CONFIRMAÇÃO DE EXCLUSÃO =================
function confirmarExclusao(titulo, mensagem, urlExclusao) {
    const titleEl = document.getElementById('modal-delete-title');
    const msgEl = document.getElementById('modal-delete-msg');
    const btnEl = document.getElementById('modal-delete-btn');

    if (titleEl) titleEl.textContent = titulo || 'Confirmar exclusão';
    if (msgEl) msgEl.textContent = mensagem || 'Tem certeza que deseja excluir este registro?';
    if (btnEl) btnEl.href = urlExclusao;

    openModal('modal-confirm-delete');
}

// ================= MODAL DE CRIANÇAS =================
function abrirModalCrianca(dados = null) {
    const modal = document.getElementById('modal-crianca');
    const form = document.getElementById('form-crianca');
    const titulo = document.getElementById('modal-crianca-title');
    if (!modal || !form) return;

    if (dados) {
        titulo.textContent = 'Editar Criança';
        form.action = 'index.php?pagina=criancas&acao=editar_crianca';
        document.getElementById('crianca-id').value = dados.id || '';
        document.getElementById('crianca-nome').value = dados.nome || '';
        document.getElementById('crianca-responsavel-id').value = dados.responsavel_id || '';
        document.getElementById('crianca-data-nasc').value = dados.data_nasc || '';
        document.getElementById('crianca-data-inicio').value = dados.data_inicio || '';
        document.getElementById('crianca-data-termino').value = dados.data_termino || '';
        document.getElementById('crianca-alergias').value = dados.alergias || '';
        document.getElementById('crianca-restricoes').value = dados.restricoes_alimentares || '';
        document.getElementById('crianca-observacoes').value = dados.observacoes_gerais || '';
    } else {
        titulo.textContent = 'Nova Criança';
        form.action = 'index.php?pagina=criancas&acao=cadastrar_crianca';
        form.reset();
        document.getElementById('crianca-id').value = '';
    }

    openModal('modal-crianca');
}

// ================= MODAL DE RESPONSÁVEIS =================
function abrirModalResponsavel(dados = null) {
    const modal = document.getElementById('modal-responsavel');
    const form = document.getElementById('form-responsavel');
    const titulo = document.getElementById('modal-responsavel-title');
    if (!modal || !form) return;

    if (dados) {
        titulo.textContent = 'Editar Responsável';
        form.action = 'index.php?pagina=responsaveis&acao=editar_responsavel';
        document.getElementById('resp-id').value = dados.id || '';
        document.getElementById('resp-nome').value = dados.nome || '';
        document.getElementById('resp-parentesco').value = dados.parentesco || '';
        document.getElementById('resp-telefone').value = dados.telefone || '';
        document.getElementById('resp-email').value = dados.email || '';
        document.getElementById('resp-endereco').value = dados.endereco || '';
    } else {
        titulo.textContent = 'Novo Responsável';
        form.action = 'index.php?pagina=responsaveis&acao=cadastrar_responsavel';
        form.reset();
        document.getElementById('resp-id').value = '';
    }

    openModal('modal-responsavel');
}

// ================= MODAL DE TAREFAS =================
function abrirModalTarefa(dados = null) {
    const modal = document.getElementById('modal-tarefa');
    const form = document.getElementById('form-tarefa');
    const titulo = document.getElementById('modal-tarefa-title');
    if (!modal || !form) return;

    if (dados) {
        titulo.textContent = 'Editar Tarefa';
        form.action = 'index.php?pagina=tarefas&acao=editar_tarefa';
        document.getElementById('tarefa-id').value = dados.id || '';
        document.getElementById('tarefa-titulo').value = dados.titulo || '';
        document.getElementById('tarefa-crianca-id').value = dados.crianca_id || '';
        document.getElementById('tarefa-horario').value = dados.horario ? dados.horario.substring(0, 5) : '';
        document.getElementById('tarefa-observacoes').value = dados.observacoes || '';
    } else {
        titulo.textContent = 'Nova Tarefa';
        form.action = 'index.php?pagina=tarefas&acao=cadastrar_tarefa';
        form.reset();
        document.getElementById('tarefa-id').value = '';
    }

    openModal('modal-tarefa');
}

// ================= MODAL DE PAGAMENTOS =================
function abrirModalPagamento(dados = null) {
    const modal = document.getElementById('modal-pagamento');
    const form = document.getElementById('form-pagamento');
    const titulo = document.getElementById('modal-pagamento-title');
    if (!modal || !form) return;

    if (dados) {
        titulo.textContent = 'Editar Pagamento';
        form.action = 'index.php?pagina=pagamentos&acao=editar_pagamento';
        document.getElementById('pag-id').value = dados.id || '';
        document.getElementById('pag-responsavel-id').value = dados.responsavel_id || '';
        document.getElementById('pag-crianca-id').value = dados.crianca_id || '';
        
        // Formatar valor numérico limpo para o campo sem multiplicar zeros
        const valorNum = parseFloat(dados.valor);
        document.getElementById('pag-valor').value = !isNaN(valorNum) ? valorNum.toFixed(2) : '';
        
        document.getElementById('pag-data-vencimento').value = dados.data_vencimento || '';
        document.getElementById('pag-status').value = dados.status || 'Pendente';
    } else {
        titulo.textContent = 'Novo Pagamento';
        form.action = 'index.php?pagina=pagamentos&acao=cadastrar_pagamento';
        form.reset();
        document.getElementById('pag-id').value = '';
    }

    openModal('modal-pagamento');
}

// ================= ALTERNAR STATUS DE TAREFA COM AJAX =================
function toggleTask(checkEl, id) {
    const taskItem = checkEl.closest('.task-item');
    if (!taskItem) return;

    fetch('index.php?acao=toggle_tarefa&id=' + id, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.sucesso) {
            const isDone = data.concluida === 1;
            if (isDone) {
                taskItem.classList.add('done');
                showToast('Tarefa marcada como concluída!', 'sucesso');
            } else {
                taskItem.classList.remove('done');
                showToast('Tarefa movida para pendentes!', 'sucesso');
            }

            // Se estiver na tela de tarefas, move suavemente entre os painéis
            const pendentesPanel = document.getElementById('tarefas-pendentes-panel');
            const concluidasPanel = document.getElementById('tarefas-concluidas-panel');

            if (pendentesPanel && concluidasPanel) {
                taskItem.style.opacity = '0';
                taskItem.style.transform = 'translateY(-6px)';
                
                setTimeout(() => {
                    if (isDone) {
                        concluidasPanel.prepend(taskItem);
                    } else {
                        pendentesPanel.prepend(taskItem);
                    }
                    taskItem.style.opacity = '1';
                    taskItem.style.transform = 'translateY(0)';
                    atualizarContadoresTarefas();
                }, 200);
            }
        } else {
            showToast('Erro ao atualizar status da tarefa.', 'erro');
        }
    })
    .catch(() => {
        // Fallback caso não seja possível usar AJAX
        window.location.href = 'index.php?acao=toggle_tarefa&id=' + id;
    });
}

function atualizarContadoresTarefas() {
    const pendentesCount = document.querySelectorAll('#tarefas-pendentes-panel .task-item').length;
    const concluidasCount = document.querySelectorAll('#tarefas-concluidas-panel .task-item').length;
    
    const countP = document.getElementById('count-pendentes');
    const countC = document.getElementById('count-concluidas');
    if (countP) countP.textContent = pendentesCount;
    if (countC) countC.textContent = concluidasCount;
}

// ================= FILTRO DE BUSCA EM TEMPO REAL =================
function aplicarFiltroBusca(inputId, seletorItens, seletorTexto) {
    const input = document.getElementById(inputId);
    if (!input) return;

    input.addEventListener('input', function () {
        const termo = this.value.toLowerCase().trim();
        const itens = document.querySelectorAll(seletorItens);

        itens.forEach(item => {
            const texto = (seletorTexto ? item.querySelector(seletorTexto) : item).textContent.toLowerCase();
            if (texto.includes(termo)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

// ================= TEMA ESCURO (DARK THEME) =================
function initTheme() {
    const toggleInput = document.getElementById('theme-toggle-input');
    const statusText = document.getElementById('theme-status-text');
    const iconWrap = document.getElementById('theme-icon-wrap');

    function applyThemeState(isDark) {
        if (isDark) {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('sitter_theme', 'dark');
            if (toggleInput) toggleInput.checked = true;
            if (statusText) statusText.textContent = 'Tema Escuro';
            if (iconWrap) {
                const moon = iconWrap.querySelector('.icon-moon');
                const sun = iconWrap.querySelector('.icon-sun');
                if (moon && sun) {
                    moon.classList.add('hidden');
                    sun.classList.remove('hidden');
                }
            }
        } else {
            document.documentElement.removeAttribute('data-theme');
            localStorage.setItem('sitter_theme', 'light');
            if (toggleInput) toggleInput.checked = false;
            if (statusText) statusText.textContent = 'Tema Claro';
            if (iconWrap) {
                const moon = iconWrap.querySelector('.icon-moon');
                const sun = iconWrap.querySelector('.icon-sun');
                if (moon && sun) {
                    moon.classList.remove('hidden');
                    sun.classList.add('hidden');
                }
            }
        }
    }

    // Estado inicial
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const isDarkInitial = currentTheme === 'dark';
    applyThemeState(isDarkInitial);

    if (toggleInput) {
        toggleInput.addEventListener('change', function () {
            applyThemeState(this.checked);
            showToast(this.checked ? 'Modo escuro ativado!' : 'Modo claro ativado!');
        });
    }

    // Permitir clicar no lado esquerdo do card para também alternar
    const cardLeft = document.querySelector('.theme-card-left');
    if (cardLeft && toggleInput) {
        cardLeft.addEventListener('click', function () {
            toggleInput.checked = !toggleInput.checked;
            toggleInput.dispatchEvent(new Event('change'));
        });
    }
}

// ================= INICIALIZAÇÃO =================
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar controle de tema
    initTheme();
    // Menu mobile
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', function (e) {
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== menuToggle) {
                sidebar.classList.remove('open');
            }
        });
    }

    // Filtros de busca dinâmica em listas
    aplicarFiltroBusca('busca-criancas', '.child-card', '.child-name');
    aplicarFiltroBusca('busca-responsaveis', '.data-table tbody tr', 'td:first-child');
    aplicarFiltroBusca('busca-pagamentos', '.data-table tbody tr', '');

    // Limpar parâmetros de feedback da URL sem recarregar a página
    const url = new URL(window.location.href);
    if (url.searchParams.has('msg')) {
        url.searchParams.delete('msg');
        window.history.replaceState({}, document.title, url.toString());
    }

    // Máscaras automáticas em inputs com atributo data-mask="telefone"
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            if (v.length > 6) {
                e.target.value = '(' + v.slice(0, 2) + ') ' + v.slice(2, 7) + '-' + v.slice(7);
            } else if (v.length > 2) {
                e.target.value = '(' + v.slice(0, 2) + ') ' + v.slice(2);
            } else if (v.length > 0) {
                e.target.value = '(' + v;
            }
        });
    });
});
