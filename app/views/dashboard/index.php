<div class="greeting">
    <h1>Bom dia, Camila</h1>
    <p>Terça-feira, 2 de setembro</p>
</div>

<div class="stat-row">
    <div class="stat-panel">
        <div class="icon-wrap"><svg>
                <use href="#i-smile" />
            </svg></div>
        <div class="num">4</div>
        <div class="lbl">Crianças ativas</div>
    </div>
    <div class="stat-panel">
        <div class="icon-wrap"><svg>
                <use href="#i-check-square" />
            </svg></div>
        <div class="num" id="dash-pendentes">3</div>
        <div class="lbl">Tarefas para hoje</div>
    </div>
    <div class="stat-panel gold">
        <div class="icon-wrap"><svg>
                <use href="#i-wallet" />
            </svg></div>
        <div class="num">R$ 2.450</div>
        <div class="lbl">Receita do mês</div>
    </div>
</div>

<div class="dash-grid">
    <div class="panel">
        <div class="panel-head">
            <h3>Receita dos últimos 6 meses</h3>
        </div>
        <div class="chart-wrap">
            <svg viewBox="0 0 320 150">
                <g>
                    <rect x="20" y="46.5" width="30" height="73.5" rx="6" fill="#71B340">
                        <title>Abril — R$ 1.800</title>
                    </rect>
                    <rect x="70" y="34.3" width="30" height="85.7" rx="6" fill="#71B340">
                        <title>Maio — R$ 2.100</title>
                    </rect>
                    <rect x="120" y="40.4" width="30" height="79.6" rx="6" fill="#71B340">
                        <title>Junho — R$ 1.950</title>
                    </rect>
                    <rect x="170" y="26.1" width="30" height="93.9" rx="6" fill="#71B340">
                        <title>Julho — R$ 2.300</title>
                    </rect>
                    <rect x="220" y="20" width="30" height="100" rx="6" fill="#568A2E">
                        <title>Agosto — R$ 2.450</title>
                    </rect>
                    <rect x="270" y="71.1" width="30" height="48.9" rx="6" fill="#D9A441">
                        <title>Setembro (parcial) — R$ 1.200</title>
                    </rect>
                </g>
                <g class="bar-lbl" text-anchor="middle">
                    <text x="35" y="136">Abr</text><text x="85" y="136">Mai</text><text x="135" y="136">Jun</text>
                    <text x="185" y="136">Jul</text><text x="235" y="136">Ago</text><text x="285" y="136">Set</text>
                </g>
            </svg>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <h3>Tarefas de hoje</h3><a href="index.php?pagina=tarefas" style="font-weight:700;">Ver todas</a>
        </div>
        <div id="dash-task-list">
            <div class="task-item">
                <div class="task-check"><svg>
                        <use href="#i-check" />
                    </svg></div>
                <div class="task-title">Dar remédio de alergia à Sofia</div>
                <div class="task-meta">14h</div>
            </div>
            <div class="task-item">
                <div class="task-check"><svg>
                        <use href="#i-check" />
                    </svg></div>
                <div class="task-title">Buscar Miguel na escola</div>
                <div class="task-meta">16h30</div>
            </div>
            <div class="task-item">
                <div class="task-check"><svg>
                        <use href="#i-check" />
                    </svg></div>
                <div class="task-title">Relatório diário — Helena</div>
                <div class="task-meta">18h</div>
            </div>
            <div class="task-item done">
                <div class="task-check"><svg>
                        <use href="#i-check" />
                    </svg></div>
                <div class="task-title">Preparar lanche da tarde</div>
                <div class="task-meta">Concluída</div>
            </div>
        </div>
    </div>
</div>

<div class="panel" style="margin-top:20px;">
    <div class="panel-head">
        <h3>Próximos pagamentos</h3><a href="index.php?pagina=pagamentos" style="font-weight:700;">Ver todos</a>
    </div>
    <table class="mini-table">
        <tr>
            <td>
                <div class="who-name">Bruno Duarte</div>
                <div class="who-sub">Responsável por Helena</div>
            </td>
            <td>R$ 480,00</td>
            <td>Vence 10/09</td>
            <td><span class="badge badge-gold">Pendente</span></td>
        </tr>
        <tr>
            <td>
                <div class="who-name">Fernanda Almeida</div>
                <div class="who-sub">Responsável por Sofia</div>
            </td>
            <td>R$ 450,00</td>
            <td>Vence 05/10</td>
            <td><span class="badge badge-gray">Agendado</span></td>
        </tr>
    </table>
</div>