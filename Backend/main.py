from random import randint, random
import dash
from dash.dependencies import Input, Output,State
from dash_html_components.Audio import Audio
from dash_html_components.Div import Div
from dash_html_components.S import S
from get_related import *
import dash_html_components as html
import pprint as pp
import dash_cytoscape as cyto
import string
import random
import dash_core_components as dcc
colors = {
    'background': '#111111',
    'text': '#7FDBFF'
}
message_node={'data': {'id': 'Base', 'url':0,'label': "Enter you fav artist's name"},'classes': 'message', 'locked': True}
external_stylesheets = ['https://codepen.io/chriddyp/pen/bWLwgP.css']
app = dash.Dash(__name__,suppress_callback_exceptions=True,external_stylesheets=external_stylesheets)
cyto.load_extra_layouts()
song_dict={}
stylesheet = [
    {
        'selector': 'node',
        'style': {
            'width': 60,
            'height': 60,
            'background-fit': 'cover',
            'font-size':20,
            'background-image': 'data(url)',
            'content': 'data(label)',
            'text-halign':'center',
            'text-valign':'bottom',
            'text-margin-y':-5,
            'text-outline-color':'white',
            'text-outline-width':2
                }
    },
    {
        'selector': '.message',
        'style': {
            'width': 60,
            'height': 60,
            'shape':'square',
            'font-size':60,
            'background-color':colors['background'],    
            'content': 'data(label)',
            'text-halign':'center',
            'text-valign':'bottom',
            'text-margin-y':-5,
            'text-outline-color':'white',
            'text-outline-width':0.5
                }
    },
    {    
                    'selector': 'edge',
                    'style': {
                            'width': 1
                                }}
    ]
app.layout = html.Div(children=[
        html.Div(
            children=[html.Div(children=
                [html.Div(
                    children=[
                        html.Div(children=[
                        dcc.Dropdown(id="link-input", value='fra',placeholder="Who is your favorite Artist?",options=[],),
                        dcc.Dropdown(
                        id='dropdown-layout',
                        value='cola',
                        options=[
                            {'label':'random','value':'random'},
                            {'label':'grid','value':'grid'},
                            {'label':'circle','value':'circle'},
                            {'label':'concentric','value':'concentric'},
                            {'label':'breadthfirst','value':'breadthfirst'},
                            {'label':'cose','value':'cose'},
                            {'label':'cose-bilkent','value':'cose-bilkent'},
                            {'label':'dagre','value':'dagre'},
                            {'label':'cola','value':'cola'},
                            {'label':'klay','value':'klay'},
                            {'label':'spread','value':'spread'},
                            {'label':'euler','value':'euler'}
                                ]
                                    )
                        ]
                        ,style={'width':'40%'}),
                        html.Button('Reset Graph ❌',id="clear-graph",style={'width':'30%'}),
                        html.Div(children=[
                            html.Div(children=[
                                    html.H6("Node Size-",style={'color':'white'}),
                                    html.Div(children=[
                                        dcc.Slider(
                                        id='node-slider',
                                        min=0,
                                        max=100,
                                        step=1,
                                        value=60)])],className="four columns"),
                            html.Div(children=[
                                html.H6("Label Size-",style={'color':'white'}),
                                html.Div(children=[
                                    dcc.Slider(
                                    id='label-slider',
                                    min=0,
                                    max=50,
                                    step=1,
                                    value=20)])],className="four columns"),
                            html.Div(children=[
                                html.H6("Edge Width-",style={'color':'white'}),
                                html.Div(children=[
                                    dcc.Slider(
                                    id='edge-slider',
                                    min=0,
                                    max=10,
                                    step=0.1,
                                    value=5)])],className="four columns")],className="row"),
                            ],style={'width':'100%'}),
                cyto.Cytoscape(
                    minZoom=0.25,
                    maxZoom=3.5,
                    autounselectify =True,
                    id='cytoscape',
                    stylesheet=stylesheet,
                    layout={'name': 'breadthfirst'},
                    style={'width': '100%', 'height': '800px' },
                    elements=[message_node]
                    )],style={'backgroundColor': colors['background'],'float':'left','width':'70%'}),
                    html.Div(children=[html.Div(id='artist-info-div', children=[
                        html.Img(height='320',width='320',id='Artist-Image',src='/assets\images\Question-Mark-PNG-Picture.png'),
                        html.Audio(id='preview-audio',src='',autoPlay=True,controls=True),
                        html.Div(
                            children=[
                                
                            ],id='artist-info')],style={'margin':'auto','width':'50%'}),
                            ],style={'float':'left','width':'30%'})]
                )
                    ],style={'backgroundColor': colors['background']})

@app.callback(Output('cytoscape', 'layout'),
              [Input('dropdown-layout', 'value')])
def update_cytoscape_layout(layout):
    return {'name': layout}

@app.callback(
    Output('artist-info', 'children'),
    [Input('cytoscape','mouseoverNodeData')]
)
def update_output_div(input_value):
    l=[]
    song_options=[]
    if input_value:
        if(input_value['url']):
            a=get_detailed_artist(input_value['id'])
            l.append(html.H3(f"{a['name']}'s top tracks are -"))
            for track in get_top_tracks(input_value['id'],sort_condition=True):
                disabled=False
                if track['audio'] == None:
                    track['audio']=''.join(random.choices(string.ascii_uppercase + string.digits, k=10))
                    disabled=True
                    pass
                song_options.append({'label':track['name'],'value':track['audio'],'disabled':disabled})
        song_options=sorted(song_options, key = lambda i: i['disabled'],reverse=False)
        l.append(dcc.RadioItems(id='song-list',options=song_options,labelStyle={'display': 'block'}))
    return l

@app.callback(Output('cytoscape', 'elements'),
              [Input('cytoscape', 'tapNodeData'),
              Input('link-input', 'value'),
              Input('clear-graph', 'n_clicks')],
              [State('cytoscape', 'elements')])
def generate_elements(nodeData,artistURL, nclicks,elements):
    ctx = dash.callback_context
    if ctx.triggered[0]['prop_id']=='link-input.value':
        elements = [get_artist(artistURL)]
        pass
    elif ctx.triggered[0]['prop_id']=='cytoscape.tapNodeData':
        if nodeData['url']:
            new_nodes,new_edges=get_related(nodeData['id'],10,0)
            for node in new_nodes:
                elements.append(node)
            for edge in new_edges:
                elements.append(edge)
    elif ctx.triggered[0]['prop_id']=='clear-graph.n_clicks':
        return [message_node]
        pass
    return elements


@app.callback(Output('Artist-Image', 'src'),
              [Input('cytoscape', 'mouseoverNodeData')])
def generate_image(mouseoverNodeData):
    if mouseoverNodeData:
        if mouseoverNodeData['url']:
            return mouseoverNodeData['url']
    return 'assets\images\Question-Mark-PNG-Picture.png'

@app.callback(Output('preview-audio', 'src'),
              [Input('song-list', 'value')])
def generate_image(song_url):
    return song_url
    
@app.callback(Output('link-input', 'options'),
              [Input('link-input', 'search_value')])
def populate_dropdown(search_query):
    options=[]
    if search_query:
        options=search_by_name(search_query)
    return options

@app.callback(Output('cytoscape', 'stylesheet'),
              [Input('node-slider', 'value'),
              Input('label-slider', 'value'),
              Input('edge-slider', 'value')])
def node_size(node_size,label_size,edge_width):
    stylesheet[0]=     {
        'selector': 'node',
        'style': {
            'width': node_size,
            'height': node_size,
            'background-fit': 'cover',
            'font-size':label_size,
            'background-image': 'data(url)',
            'content': 'data(label)',
            'text-halign':'center',
            'text-valign':'bottom',
            'text-margin-y':-5,
            'text-outline-color':'white',
            'text-outline-width':label_size/10
                }
    }
    stylesheet[2]={    
                    'selector': 'edge',
                    'style': {
                            'width': edge_width
                                }}
    return stylesheet


if __name__ == '__main__':
    app.run_server(debug=False)