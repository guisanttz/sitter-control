<div class="list-head">
    <div class="counter-row">
        <div class="counter-pill">Pendentes: <span id="count-pendentes">3</span></div>
        <div class="counter-pill">Concluídas: <span id="count-concluidas">1</span></div>
    </div>
    <div class="head-actions">
        <button class="btn btn-primary" onclick="openModal('tarefa')"><svg>
                <use href="#i-plus" />
            </svg>Nova tarefa</button>
    </div>
</div>

<p class="task-section-title">Hoje</p>
<div class="task-list-panel" id="tarefas-pendentes-panel">
    <div class="task-item">
        <div class="task-check" onclick="toggleTask(this)"><svg>
                <use href="#i-check" />
            </svg></div>
        <div class="task-title">Dar remédio de alergia à Sofia</div><span class="tag">Sofia</span>
        <div class="task-meta">14h</div>
        <div class="task-row-actions"><button onclick="openModal('tarefa')"><svg>
                    <use href="#i-pencil" />
                </svg></button><button><svg>
                    <use href="#i-trash" />
                </svg></button></div>
    </div>
    <div class="task-item">
        <div class="task-check" onclick="toggleTask(this)"><svg>
                <use href="#i-check" />
            </svg></div>
        <div class="task-title">Buscar Miguel na escola</div><span class="tag">Miguel</span>
        <div class="task-meta">16h30</div>
        <div class="task-row-actions"><button onclick="openModal('tarefa')"><svg>
                    <use href="#i-pencil" />
                </svg></button><button><svg>
                    <use href="#i-trash" />
                </svg></button></div>
    </div>
</div>

<p class="task-section-title">Concluídas</p>
<div class="task-list-panel" id="tarefas-concluidas-panel">
    <div class="task-item done">
        <div class="task-check" onclick="toggleTask(this)"><svg>
                <use href="#i-check" />
            </svg></div>
        <div class="task-title">Preparar lanche da tarde</div><span class="tag">Todas</span>
        <div class="task-meta">Hoje</div>
        <div class="task-row-actions"><button onclick="openModal('tarefa')"><svg>
                    <use href="#i-pencil" />
                </svg></button><button><svg>
                    <use href="#i-trash" />
                </svg></button></div>
    </div>
</div>